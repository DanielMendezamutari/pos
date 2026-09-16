<?php
/**
 * Servicio de Dominio para Control Antirrobo, Relevos de Turno y Monitoreo en el Dashboard
 * Cumple con principios SOLID (Responsabilidad Única, Inversión de Dependencias, Alta Cohesión)
 */

require_once("classconexion.php");

class DashboardControlService {

    private $dbh;

    public function __construct($dbh = null) {
        if ($dbh instanceof PDO) {
            $this->dbh = $dbh;
        } else {
            $db = new Db();
            $reflector = new ReflectionClass('Db');
            if ($reflector->hasProperty('dbh')) {
                $prop = $reflector->getProperty('dbh');
                $prop->setAccessible(true);
                $this->dbh = $prop->getValue($db);
            }
        }
    }

    /**
     * Obtiene los KPIs consolidados de inventario inicial y relevos del día de hoy,
     * discriminando inteligentemente entre faltantes PENDIENTES reales vs. los que ya
     * fueron CUADRADOS/AJUSTADOS (manual o por ingreso de compras atrasadas).
     *
     * @param string $fecha YYYY-MM-DD (por defecto hoy)
     * @return array
     */
    public function obtenerKpisInventarioHoy($fecha = '') {
        if (empty($fecha)) {
            $fecha = date('Y-m-d');
        }

        try {
            // 1. Obtener todos los ítems con diferencias de hoy y cruzar con compras del día y estado de ajuste
            $sqlItems = "SELECT 
                cid.idconteo,
                cid.codsucursal,
                d.iddetalleconteo,
                d.idproducto,
                d.codproducto,
                d.producto,
                d.cantidad_fisica,
                d.stock_sistema,
                d.diferencia,
                d.ajustado,
                d.motivo_ajuste,
                COALESCE(p.preciocompra, 0.00) AS preciocompra,
                COALESCE(comp_stat.total_comprado_dia, 0) AS compras_del_dia
            FROM detalle_conteo_inicial d
            INNER JOIN conteo_inicial_diario cid ON d.idconteo = cid.idconteo
            LEFT JOIN productos p ON (d.idproducto = p.idproducto AND p.codsucursal = cid.codsucursal)
            LEFT JOIN (
                SELECT 
                    dc.idproducto,
                    dc.codsucursal,
                    SUM(dc.cantcompra) AS total_comprado_dia
                FROM detallecompras dc
                INNER JOIN compras c ON dc.codcompra = c.codcompra
                WHERE DATE(c.fecharecepcion) = ? OR DATE(c.fechaemision) = ?
                GROUP BY dc.idproducto, dc.codsucursal
            ) comp_stat ON (d.idproducto = comp_stat.idproducto AND cid.codsucursal = comp_stat.codsucursal)
            WHERE DATE(cid.fechaconteo) = ? AND d.diferencia != 0";

            $stmt = $this->dbh->prepare($sqlItems);
            $stmt->execute(array($fecha, $fecha, $fecha));
            $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // 2. Conteo de inventarios iniciales totales de hoy
            $sqlTotalConteos = "SELECT COUNT(*) AS total FROM conteo_inicial_diario WHERE DATE(fechaconteo) = ?";
            $stmtTotal = $this->dbh->prepare($sqlTotalConteos);
            $stmtTotal->execute(array($fecha));
            $rowTotal = $stmtTotal->fetch(PDO::FETCH_ASSOC);
            $totalConteosHoy = (int)($rowTotal['total'] ?? 0);

            // 3. Procesar ítems discriminando pendientes vs resueltos
            $conteosConPendientes = array();
            $conteosConDiferencias = array();
            $faltantesPendientesUds = 0;
            $faltantesPendientesCosto = 0;
            $cuadradosAjustadosUds = 0;
            $cuadradosAjustadosCosto = 0;
            $cuadradosComprasUds = 0;
            $cuadradosComprasCosto = 0;

            foreach ($items as $it) {
                $idconteo = (int)$it['idconteo'];
                $dif = (float)$it['diferencia'];
                $esAjustado = ((int)$it['ajustado'] === 1);
                $comprasDia = (float)$it['compras_del_dia'];
                $costoUnit = (float)$it['preciocompra'];

                $conteosConDiferencias[$idconteo] = true;

                if ($dif < 0) {
                    $faltante = abs($dif);

                    if ($esAjustado) {
                        // Ya fue cuadrado/ajustado en el sistema por el administrador
                        $cuadradosAjustadosUds += $faltante;
                        $cuadradosAjustadosCosto += ($faltante * $costoUnit);
                    } elseif ($comprasDia >= $faltante) {
                        // Cuadrado automáticamente porque ingresó la compra atrasada hoy
                        $cuadradosComprasUds += $faltante;
                        $cuadradosComprasCosto += ($faltante * $costoUnit);
                    } else {
                        // Sigue pendiente de resolver
                        $faltantesPendientesUds += $faltante;
                        $faltantesPendientesCosto += ($faltante * $costoUnit);
                        $conteosConPendientes[$idconteo] = true;
                    }
                } else {
                    // Sobrante
                    if (!$esAjustado) {
                        // No considerado pérdida económica, pero si no está ajustado se mantiene como observación leve
                    }
                }
            }

            $numConteosConDiferencia = count($conteosConDiferencias);
            $numConteosConPendientes = count($conteosConPendientes);
            $numConteosResueltos = $numConteosConDiferencia - $numConteosConPendientes;
            $numConteosCuadradosOriginales = max(0, $totalConteosHoy - $numConteosConDiferencia);
            $numConteosTotalmenteCuadrados = $numConteosCuadradosOriginales + $numConteosResueltos;

            // 4. Conteo de cajas abiertas actualmente y cuántas no han contado
            $sqlCajas = "SELECT 
                a.codarqueo,
                a.codcaja,
                cid.idconteo
            FROM arqueocaja a
            INNER JOIN cajas c ON a.codcaja = c.codcaja
            LEFT JOIN conteo_inicial_diario cid ON (
                (cid.codarqueo = a.codarqueo AND cid.codarqueo IS NOT NULL AND cid.codarqueo > 0)
                OR (cid.codcaja = a.codcaja AND DATE(cid.fechaconteo) = DATE(a.fechaapertura))
            )
            WHERE a.statusarqueo = 1 AND c.nomcaja NOT LIKE '%ADM%'
            GROUP BY a.codarqueo";

            $stmtCajas = $this->dbh->query($sqlCajas);
            $cajasAbiertas = $stmtCajas->fetchAll(PDO::FETCH_ASSOC);

            $totalCajasAbiertas = count($cajasAbiertas);
            $cajasSinConteo = 0;

            foreach ($cajasAbiertas as $ca) {
                if (empty($ca['idconteo'])) {
                    $cajasSinConteo++;
                }
            }

            // 5. Conteo rápido de faltantes pendientes de días anteriores
            $sqlAnt = "SELECT 
                COALESCE(SUM(ABS(d.diferencia)), 0) AS total_uds_ant,
                COALESCE(SUM(ABS(d.diferencia) * COALESCE(p.preciocompra, 0)), 0) AS total_costo_ant,
                COUNT(DISTINCT cid.idconteo) AS total_conteos_ant
            FROM detalle_conteo_inicial d
            INNER JOIN conteo_inicial_diario cid ON d.idconteo = cid.idconteo
            LEFT JOIN productos p ON (d.idproducto = p.idproducto AND p.codsucursal = cid.codsucursal)
            WHERE DATE(cid.fechaconteo) < ?
              AND d.diferencia < 0
              AND (d.ajustado IS NULL OR d.ajustado = 0)";
            $stmtAnt = $this->dbh->prepare($sqlAnt);
            $stmtAnt->execute(array($fecha));
            $rowAnt = $stmtAnt->fetch(PDO::FETCH_ASSOC);

            return array(
                'total_conteos_hoy' => $totalConteosHoy,
                'conteos_cuadrados_original' => $numConteosCuadradosOriginales,
                'conteos_resueltos' => $numConteosResueltos,
                'conteos_cuadrados_totales' => $numConteosTotalmenteCuadrados,
                'conteos_con_pendientes' => $numConteosConPendientes,
                'unidades_faltantes_pendientes' => $faltantesPendientesUds,
                'costo_faltante_pendiente' => $faltantesPendientesCosto,
                'unidades_cuadradas_ajuste' => $cuadradosAjustadosUds,
                'unidades_cuadradas_compra' => $cuadradosComprasUds,
                'unidades_cuadradas_total' => ($cuadradosAjustadosUds + $cuadradosComprasUds),
                'costo_cuadrado_total' => ($cuadradosAjustadosCosto + $cuadradosComprasCosto),
                'total_cajas_abiertas' => $totalCajasAbiertas,
                'cajas_sin_conteo' => $cajasSinConteo,
                'dias_anteriores_faltantes_uds' => (float)($rowAnt['total_uds_ant'] ?? 0),
                'dias_anteriores_costo_faltante' => (float)($rowAnt['total_costo_ant'] ?? 0),
                'dias_anteriores_conteos' => (int)($rowAnt['total_conteos_ant'] ?? 0)
            );
        } catch (Exception $e) {
            error_log("Error en DashboardControlService::obtenerKpisInventarioHoy: " . $e->getMessage());
            return array(
                'total_conteos_hoy' => 0,
                'conteos_cuadrados_original' => 0,
                'conteos_resueltos' => 0,
                'conteos_cuadrados_totales' => 0,
                'conteos_con_pendientes' => 0,
                'unidades_faltantes_pendientes' => 0,
                'costo_faltante_pendiente' => 0.00,
                'unidades_cuadradas_ajuste' => 0,
                'unidades_cuadradas_compra' => 0,
                'unidades_cuadradas_total' => 0,
                'costo_cuadrado_total' => 0.00,
                'total_cajas_abiertas' => 0,
                'cajas_sin_conteo' => 0
            );
        }
    }

    /**
     * Obtiene el semáforo en vivo de las cajas abiertas y su estado de relevo,
     * detectando si las diferencias ya fueron ajustadas o cuadradas con compras.
     *
     * @return array
     */
    public function obtenerSemaforoCajasAbiertas() {
        try {
            $sql = "SELECT 
                a.codarqueo,
                a.codcaja,
                c.codsucursal,
                a.montoinicial,
                a.fechaapertura,
                c.nomcaja,
                c.nrocaja,
                s.nomsucursal,
                u.nombres AS cajero,
                cid.idconteo,
                cid.fechaconteo,
                cid.turno,
                u_conteo.nombres AS usuario_conteo
            FROM arqueocaja a
            INNER JOIN cajas c ON a.codcaja = c.codcaja
            INNER JOIN sucursales s ON c.codsucursal = s.codsucursal
            INNER JOIN usuarios u ON c.codigo = u.codigo
            LEFT JOIN conteo_inicial_diario cid ON (
                (cid.codarqueo = a.codarqueo AND cid.codarqueo IS NOT NULL AND cid.codarqueo > 0)
                OR (cid.codcaja = a.codcaja AND DATE(cid.fechaconteo) = DATE(a.fechaapertura))
            )
            LEFT JOIN usuarios u_conteo ON cid.codusuario = u_conteo.codigo
            WHERE a.statusarqueo = 1 AND c.nomcaja NOT LIKE '%ADM%'
            GROUP BY a.codarqueo
            ORDER BY a.fechaapertura DESC";

            $stmt = $this->dbh->query($sql);
            $cajas = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $resultado = array();
            $ahora = time();

            foreach ($cajas as $row) {
                $fechaAperturaTime = strtotime($row['fechaapertura']);
                $minutosAbierta = max(0, round(($ahora - $fechaAperturaTime) / 60));
                $idconteo = !empty($row['idconteo']) ? (int)$row['idconteo'] : 0;

                if ($idconteo === 0) {
                    // No ha contado todavía
                    $row['estado_semaforo'] = 'AMARILLO';
                    $row['badge_clase'] = 'badge-warning';
                    $row['estado_texto'] = 'PENDIENTE DE CONTEO';
                    $row['mensaje_alerta'] = "Caja abierta hace {$minutosAbierta} min sin conteo inicial";
                    $row['unidades_faltantes'] = 0;
                    $row['unidades_cuadradas'] = 0;
                } else {
                    // Analizar los detalles del conteo para ver si hay pendientes o todo está cuadrado
                    $sqlDet = "SELECT 
                        d.iddetalleconteo,
                        d.idproducto,
                        d.diferencia,
                        d.ajustado,
                        COALESCE(comp_stat.total_comprado_dia, 0) AS compras_del_dia
                    FROM detalle_conteo_inicial d
                    LEFT JOIN (
                        SELECT 
                            dc.idproducto,
                            dc.codsucursal,
                            SUM(dc.cantcompra) AS total_comprado_dia
                        FROM detallecompras dc
                        INNER JOIN compras c ON dc.codcompra = c.codcompra
                        WHERE DATE(c.fecharecepcion) = ? OR DATE(c.fechaemision) = ?
                        GROUP BY dc.idproducto, dc.codsucursal
                    ) comp_stat ON (d.idproducto = comp_stat.idproducto AND comp_stat.codsucursal = ?)
                    WHERE d.idconteo = ? AND d.diferencia != 0";

                    $fechaConteo = date('Y-m-d', strtotime($row['fechaconteo']));
                    $stmtDet = $this->dbh->prepare($sqlDet);
                    $stmtDet->execute(array($fechaConteo, $fechaConteo, (int)$row['codsucursal'], $idconteo));
                    $detalles = $stmtDet->fetchAll(PDO::FETCH_ASSOC);

                    $faltantesPendientes = 0;
                    $cuadradasAjustadas = 0;

                    foreach ($detalles as $d) {
                        $dif = (float)$d['diferencia'];
                        $esAjustado = ((int)$d['ajustado'] === 1);
                        $compras = (float)$d['compras_del_dia'];

                        if ($dif < 0) {
                            $f = abs($dif);
                            if ($esAjustado || $compras >= $f) {
                                $cuadradasAjustadas += $f;
                            } else {
                                $faltantesPendientes += $f;
                            }
                        }
                    }

                    $row['unidades_faltantes'] = $faltantesPendientes;
                    $row['unidades_cuadradas'] = $cuadradasAjustadas;

                    if ($faltantesPendientes > 0) {
                        // Sigue habiendo faltante sin justificar
                        $row['estado_semaforo'] = 'ROJO';
                        $row['badge_clase'] = 'badge-danger';
                        $row['estado_texto'] = 'FALTANTE PENDIENTE';
                        $row['mensaje_alerta'] = "Discrepancia sin resolver: -{$faltantesPendientes} uds";
                    } elseif ($cuadradasAjustadas > 0) {
                        // Tuvo diferencias pero ya fueron ajustadas o cubiertas por compra
                        $row['estado_semaforo'] = 'AZUL';
                        $row['badge_clase'] = 'badge-info';
                        $row['estado_texto'] = 'CUADRADO / AJUSTADO';
                        $row['mensaje_alerta'] = "Cuadrado por ajuste o compra atrasada ({$cuadradasAjustadas} uds resueltas)";
                    } else {
                        // No tuvo ninguna diferencia desde el inicio
                        $row['estado_semaforo'] = 'VERDE';
                        $row['badge_clase'] = 'badge-success';
                        $row['estado_texto'] = '100% CUADRADO';
                        $row['mensaje_alerta'] = "Inventario inicial verificado sin faltantes";
                    }
                }

                $row['minutos_abierta'] = $minutosAbierta;
                $resultado[] = $row;
            }

            return $resultado;
        } catch (Exception $e) {
            error_log("Error en DashboardControlService::obtenerSemaforoCajasAbiertas: " . $e->getMessage());
            return array();
        }
    }

    /**
     * Obtiene los últimos conteos iniciales registrados en el sistema con su estado de resolución
     *
     * @param int $limite Cantidad de registros a retornar
     * @return array
     */
    public function obtenerUltimosConteos($limite = 6) {
        $limite = (int)$limite;
        if ($limite <= 0) $limite = 6;

        try {
            $sql = "SELECT 
                cid.idconteo,
                cid.fechaconteo,
                cid.turno,
                cid.codsucursal,
                s.nomsucursal,
                COALESCE(c.nomcaja, cid.turno, 'CAJA') AS nomcaja,
                COALESCE(u.nombres, 'Cajero') AS usuario_conteo,
                COUNT(dci.iddetalleconteo) AS total_items,
                SUM(CASE WHEN dci.diferencia != 0 THEN 1 ELSE 0 END) AS items_con_diferencia,
                SUM(CASE WHEN dci.diferencia < 0 THEN ABS(dci.diferencia) ELSE 0 END) AS unidades_faltantes_total,
                SUM(CASE WHEN dci.diferencia < 0 AND dci.ajustado = 1 THEN ABS(dci.diferencia) ELSE 0 END) AS unidades_ajustadas,
                SUM(CASE WHEN dci.diferencia < 0 AND (dci.ajustado IS NULL OR dci.ajustado = 0) THEN ABS(dci.diferencia) ELSE 0 END) AS unidades_faltantes_sin_ajuste,
                SUM(CASE WHEN dci.diferencia < 0 AND (dci.ajustado IS NULL OR dci.ajustado = 0) THEN ABS(dci.diferencia) * COALESCE(p.preciocompra, 0) ELSE 0 END) AS costo_faltante_pendiente
            FROM conteo_inicial_diario cid
            INNER JOIN sucursales s ON cid.codsucursal = s.codsucursal
            LEFT JOIN cajas c ON cid.codcaja = c.codcaja
            LEFT JOIN usuarios u ON cid.codusuario = u.codigo
            LEFT JOIN detalle_conteo_inicial dci ON cid.idconteo = dci.idconteo
            LEFT JOIN productos p ON (dci.idproducto = p.idproducto AND p.codsucursal = cid.codsucursal)
            GROUP BY cid.idconteo
            ORDER BY cid.idconteo DESC
            LIMIT {$limite}";

            $stmt = $this->dbh->query($sql);
            $conteos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($conteos as &$con) {
                $totalDif = (int)$con['items_con_diferencia'];
                $faltanteSinAjuste = (float)$con['unidades_faltantes_sin_ajuste'];
                $ajustadas = (float)$con['unidades_ajustadas'];

                // Verificar si hay compras de la fecha para ítems sin ajuste
                if ($faltanteSinAjuste > 0) {
                    $sqlCompCheck = "SELECT COALESCE(SUM(dc.cantcompra), 0) AS compras_cubiertas
                        FROM detalle_conteo_inicial d
                        INNER JOIN detallecompras dc ON (d.idproducto = dc.idproducto AND dc.codsucursal = ?)
                        INNER JOIN compras c ON dc.codcompra = c.codcompra
                        WHERE d.idconteo = ? AND d.diferencia < 0 AND (d.ajustado IS NULL OR d.ajustado = 0)
                          AND (DATE(c.fecharecepcion) = ? OR DATE(c.fechaemision) = ?)";
                    $fechaC = date('Y-m-d', strtotime($con['fechaconteo']));
                    $stmtC = $this->dbh->prepare($sqlCompCheck);
                    $stmtC->execute(array((int)$con['codsucursal'], (int)$con['idconteo'], $fechaC, $fechaC));
                    $rowC = $stmtC->fetch(PDO::FETCH_ASSOC);
                    $comprasCubiertas = (float)($rowC['compras_cubiertas'] ?? 0);

                    if ($comprasCubiertas >= $faltanteSinAjuste) {
                        $con['cuadrado_por_compra'] = true;
                        $con['unidades_faltantes_sin_ajuste'] = 0;
                        $faltanteSinAjuste = 0;
                    }
                }

                if ($totalDif === 0) {
                    $con['estado_cuadre'] = 'CUADRADO_ORIGINAL';
                    $con['badge_clase'] = 'badge-success';
                    $con['texto_resultado'] = '100% Cuadrado';
                    $con['icono'] = 'fa-check';
                } elseif ($faltanteSinAjuste == 0) {
                    $con['estado_cuadre'] = 'CUADRADO_AJUSTADO';
                    $con['badge_clase'] = 'badge-info';
                    $con['texto_resultado'] = !empty($con['cuadrado_por_compra']) ? '📦 Cuadrado p/ Compra' : '✓ Cuadrado / Ajustado';
                    $con['icono'] = !empty($con['cuadrado_por_compra']) ? 'fa-cube' : 'fa-check-circle';
                } else {
                    $con['estado_cuadre'] = 'FALTANTE_PENDIENTE';
                    $con['badge_clase'] = 'badge-danger';
                    $con['texto_resultado'] = '-' . number_format($faltanteSinAjuste, 0) . ' uds Pendiente';
                    $con['icono'] = 'fa-warning';
                }
            }
            unset($con);

            return $conteos;
        } catch (Exception $e) {
            error_log("Error en DashboardControlService::obtenerUltimosConteos: " . $e->getMessage());
            return array();
        }
    }

    /**
     * Obtiene los faltantes pendientes no resueltos de días anteriores,
     * agrupados cronológicamente por conteo y sucursal.
     *
     * @param int $limite Cantidad máxima de registros
     * @return array
     */
    public function obtenerFaltantesDiasAnteriores($limite = 30) {
        $limite = (int)$limite;
        if ($limite <= 0) $limite = 30;

        try {
            $sql = "SELECT 
                cid.idconteo,
                DATE(cid.fechaconteo) AS fecha,
                cid.fechaconteo,
                cid.codsucursal,
                s.nomsucursal,
                COALESCE(cid.turno, c.nomcaja, 'CAJA') AS turno,
                COALESCE(u.nombres, 'Cajero') AS cajero,
                COUNT(DISTINCT d.iddetalleconteo) AS prods_con_faltante,
                SUM(ABS(d.diferencia)) AS unidades_faltantes,
                SUM(ABS(d.diferencia) * COALESCE(p.preciocompra, 0)) AS costo_faltante
            FROM conteo_inicial_diario cid
            INNER JOIN sucursales s ON cid.codsucursal = s.codsucursal
            LEFT JOIN cajas c ON cid.codcaja = c.codcaja
            LEFT JOIN usuarios u ON cid.codusuario = u.codigo
            INNER JOIN detalle_conteo_inicial d ON cid.idconteo = d.idconteo
            LEFT JOIN productos p ON (d.idproducto = p.idproducto AND p.codsucursal = cid.codsucursal)
            WHERE DATE(cid.fechaconteo) < CURDATE()
              AND d.diferencia < 0
              AND (d.ajustado IS NULL OR d.ajustado = 0)
            GROUP BY cid.idconteo
            ORDER BY cid.fechaconteo DESC
            LIMIT {$limite}";

            $stmt = $this->dbh->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error en DashboardControlService::obtenerFaltantesDiasAnteriores: " . $e->getMessage());
            return array();
        }
    }
}
