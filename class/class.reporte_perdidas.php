<?php
/**
 * Servicio de Dominio para Reporte Consolidado y Ejecutivo de Pérdidas para Propietarios
 * Clasifica claramente:
 * 1. Faltantes en Caja (Sin justificar / A investigar o cobrar al cajero)
 * 2. Retiros de la Dueña (Consumo propio / autorizados)
 * 3. Mermas y Roturas (Botellas rotas, etc.)
 * 4. Ajustes / Cuadres Aclarados (Errores de conteo ya justificados con su motivo)
 */

require_once("classconexion.php");

class ReportePerdidasService {

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
     * Obtiene la lista unificada y clasificada de diferencias
     *
     * @param int $codsucursal ID de sucursal (0 para todas)
     * @param string $desde Fecha inicial YYYY-MM-DD
     * @param string $hasta Fecha final YYYY-MM-DD
     * @param string $filtroCategoria 'TODAS', 'FALTANTES_CAJA', 'RETIROS_DUENA', 'MERMAS', 'ACLARADOS'
     * @return array
     */
    public function obtenerPerdidas($codsucursal = 0, $desde = '', $hasta = '', $filtroCategoria = 'TODAS', $agrupado = false) {
        $codsucursal = (int)$codsucursal;
        $filtroCategoria = strtoupper(trim($filtroCategoria));

        if (empty($desde)) $desde = date('Y-m-01');
        if (empty($hasta)) $hasta = date('Y-m-d');

        $fechaDesdeCompleta = $desde . " 00:00:00";
        $fechaHastaCompleta = $hasta . " 23:59:59";

        $registros = [];

        // 1. Faltantes de Conteos Diarios (2:00 PM)
        $sqlConteos = "SELECT 
            'CONTEO' AS origen_tabla,
            c.idconteo AS id_referencia,
            CONCAT('#', LPAD(c.idconteo, 5, '0')) AS codigo_referencia,
            c.fechaconteo AS fecha,
            c.codsucursal,
            s.cuitsucursal,
            s.nomsucursal,
            d.idproducto,
            d.codproducto,
            d.producto,
            ABS(d.diferencia) AS cantidad_perdida,
            COALESCE(p.preciocompra, 0.00) AS preciocompra,
            (ABS(d.diferencia) * COALESCE(p.preciocompra, 0.00)) AS total_costo,
            COALESCE(p.precioxpublico, 0.00) AS precioxpublico,
            (ABS(d.diferencia) * COALESCE(p.precioxpublico, 0.00)) AS total_venta,
            COALESCE(u.nombres, u.usuario, 'Cajero de Turno') AS responsable,
            COALESCE(c.turno, '') AS turno,
            d.ajustado,
            COALESCE(d.motivo_ajuste, '') AS motivo_ajuste,
            COALESCE(c.observaciones, '') AS obs_conteo
            FROM detalle_conteo_inicial d
            INNER JOIN conteo_inicial_diario c ON d.idconteo = c.idconteo
            INNER JOIN sucursales s ON c.codsucursal = s.codsucursal
            LEFT JOIN usuarios u ON c.codusuario = u.codigo
            LEFT JOIN productos p ON (d.idproducto = p.idproducto AND p.codsucursal = c.codsucursal)
            WHERE d.diferencia < -0.001
            AND c.fechaconteo BETWEEN ? AND ?
            " . ($codsucursal > 0 ? "AND c.codsucursal = ?" : "");

        $paramsC = [$fechaDesdeCompleta, $fechaHastaCompleta];
        if ($codsucursal > 0) $paramsC[] = $codsucursal;

        $stmtC = $this->dbh->prepare($sqlConteos);
        $stmtC->execute($paramsC);
        $filasC = $stmtC->fetchAll(PDO::FETCH_ASSOC);

        foreach ($filasC as $fc) {
            $catCodigo = 'FALTANTES_CAJA';
            $catNombre = 'Faltante en Caja';
            $badgeClase = 'badge-danger';
            $razonReal = 'Faltó en conteo físico a ciegas (Sin justificación)';

            if ((int)$fc['ajustado'] === 1 && !empty($fc['motivo_ajuste'])) {
                $catCodigo = 'ACLARADOS';
                $catNombre = 'Cuadrado / Aclarado';
                $badgeClase = 'badge-success';
                $razonReal = 'Aclarado: ' . trim($fc['motivo_ajuste']);
            } elseif (!empty($fc['obs_conteo'])) {
                $catCodigo = 'ACLARADOS';
                $catNombre = 'Con Observación';
                $badgeClase = 'badge-info';
                $razonReal = 'Nota turno: ' . trim($fc['obs_conteo']);
            }

            // Aplicar filtro si el usuario seleccionó una categoría específica
            if ($filtroCategoria !== 'TODAS' && $filtroCategoria !== $catCodigo) {
                continue;
            }

            if (!empty($fc['turno'])) {
                $fc['responsable'] .= ' (' . $fc['turno'] . ')';
            }

            $fc['categoria_codigo'] = $catCodigo;
            $fc['categoria_nombre'] = $catNombre;
            $fc['badge_clase'] = $badgeClase;
            $fc['razon_real'] = $razonReal;

            $registros[] = $fc;
        }

        // 2. Retiros y Bajas de Inventario
        $sqlBajas = "SELECT 
            'BAJA' AS origen_tabla,
            b.idbaja AS id_referencia,
            b.codbaja AS codigo_referencia,
            b.fechabaja AS fecha,
            b.codsucursal,
            s.cuitsucursal,
            s.nomsucursal,
            db.idproducto,
            db.codproducto,
            db.producto,
            db.cantidad AS cantidad_perdida,
            COALESCE(db.preciocompra, 0.00) AS preciocompra,
            COALESCE(db.subtotal_costo, (db.cantidad * COALESCE(db.preciocompra, 0.00))) AS total_costo,
            COALESCE(db.precioxpublico, 0.00) AS precioxpublico,
            (db.cantidad * COALESCE(db.precioxpublico, 0.00)) AS total_venta,
            COALESCE(b.persona_autoriza, 'Administración') AS responsable,
            b.tipomotivo,
            COALESCE(b.observaciones, '') AS obs_baja
            FROM detalle_bajas_inventario db
            INNER JOIN bajas_inventario b ON db.idbaja = b.idbaja
            INNER JOIN sucursales s ON b.codsucursal = s.codsucursal
            WHERE b.statusbaja != 'ANULADA'
            AND b.fechabaja BETWEEN ? AND ?
            " . ($codsucursal > 0 ? "AND b.codsucursal = ?" : "");

        $paramsB = [$fechaDesdeCompleta, $fechaHastaCompleta];
        if ($codsucursal > 0) $paramsB[] = $codsucursal;

        $stmtB = $this->dbh->prepare($sqlBajas);
        $stmtB->execute($paramsB);
        $filasB = $stmtB->fetchAll(PDO::FETCH_ASSOC);

        foreach ($filasB as $fb) {
            $tipoMot = strtoupper($fb['tipomotivo']);
            $obs = trim($fb['obs_baja']);

            if ($tipoMot === 'RETIRO_DUENA') {
                $catCodigo = 'RETIROS_DUENA';
                $catNombre = 'Retiro de la Dueña';
                $badgeClase = 'badge-primary';
                $razonReal = !empty($obs) ? "Retiro Dueña: " . $obs : "Retiro personal autorizado por la dueña";
            } elseif ($tipoMot === 'MERMA' || $tipoMot === 'VENCIDO') {
                $catCodigo = 'MERMAS';
                $catNombre = 'Merma / Rotura';
                $badgeClase = 'badge-warning text-dark';
                $razonReal = !empty($obs) ? "Merma: " . $obs : "Producto roto / dañado / vencido";
            } else {
                $catCodigo = 'MERMAS';
                $catNombre = 'Salida / Baja: ' . $fb['tipomotivo'];
                $badgeClase = 'badge-secondary';
                $razonReal = !empty($obs) ? $obs : "Salida registrada en sistema";
            }

            if ($filtroCategoria !== 'TODAS' && $filtroCategoria !== $catCodigo) {
                continue;
            }

            $fb['categoria_codigo'] = $catCodigo;
            $fb['categoria_nombre'] = $catNombre;
            $fb['badge_clase'] = $badgeClase;
            $fb['razon_real'] = $razonReal;

            $registros[] = $fb;
        }

        // Ordenar cronológicamente descendente
        usort($registros, function($a, $b) {
            return strtotime($b['fecha']) - strtotime($a['fecha']);
        });

        return $registros;
    }

    /**
     * Calcula métricas y KPIs ejecutivos orientados a la dueña
     *
     * @param array $registros
     * @return array
     */
    public function calcularResumenKPIs($registros) {
        $totalUnidades = 0.00;
        $totalVenta = 0.00;
        $totalCosto = 0.00;

        $montoFaltantesCaja = 0.00;
        $unidadesFaltantesCaja = 0.00;

        $montoRetirosDuena = 0.00;
        $unidadesRetirosDuena = 0.00;

        $montoMermas = 0.00;
        $unidadesMermas = 0.00;

        $montoAclarados = 0.00;
        $unidadesAclarados = 0.00;

        foreach ($registros as $r) {
            $cant = (float)$r['cantidad_perdida'];
            $venta = (float)$r['total_venta'];
            $costo = (float)$r['total_costo'];

            $totalUnidades += $cant;
            $totalVenta += $venta;
            $totalCosto += $costo;

            switch ($r['categoria_codigo']) {
                case 'FALTANTES_CAJA':
                    $montoFaltantesCaja += $venta;
                    $unidadesFaltantesCaja += $cant;
                    break;
                case 'RETIROS_DUENA':
                    $montoRetirosDuena += $venta;
                    $unidadesRetirosDuena += $cant;
                    break;
                case 'MERMAS':
                    $montoMermas += $venta;
                    $unidadesMermas += $cant;
                    break;
                case 'ACLARADOS':
                    $montoAclarados += $venta;
                    $unidadesAclarados += $cant;
                    break;
            }
        }

        return [
            'total_eventos'          => count($registros),
            'total_unidades'         => $totalUnidades,
            'total_venta'            => $totalVenta,
            'total_costo'            => $totalCosto,
            // Separación ejecutiva para la dueña:
            'monto_faltantes_caja'   => $montoFaltantesCaja,
            'unid_faltantes_caja'    => $unidadesFaltantesCaja,
            'monto_retiros_duena'    => $montoRetirosDuena,
            'unid_retiros_duena'     => $unidadesRetirosDuena,
            'monto_mermas'           => $montoMermas,
            'unid_mermas'            => $unidadesMermas,
            'monto_aclarados'        => $montoAclarados,
            'unid_aclarados'         => $unidadesAclarados
        ];
    }

    public function obtenerSucursalInfo($codsucursal) {
        $codsucursal = (int)$codsucursal;
        if ($codsucursal <= 0) {
            return [
                'codsucursal' => 0,
                'cuitsucursal' => 'ALL',
                'nomsucursal' => 'TODAS LAS SUCURSALES'
            ];
        }

        $stmt = $this->dbh->prepare("SELECT codsucursal, cuitsucursal, nomsucursal FROM sucursales WHERE codsucursal = ?");
        $stmt->execute([$codsucursal]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ?: [
            'codsucursal' => $codsucursal,
            'cuitsucursal' => '',
            'nomsucursal' => 'SUCURSAL DESCONOCIDA'
        ];
    }

    /**
     * Rastrea la trazabilidad turno por turno de un producto faltante
     * Busca el conteo inmediatamente anterior, la ventana de tiempo,
     * los cajeros que operaron en ese intervalo y cuántas unidades vendió cada uno
     */
    public function rastrearTurnosFaltante($codproducto, $codsucursal, $fechaConteoActual) {
        $codsucursal = (int)$codsucursal;
        $codproducto = trim($codproducto);

        // 1. Buscar el conteo inmediatamente anterior para este producto en la misma sucursal
        $sqlPrev = "SELECT c.idconteo, c.fechaconteo, d.stock_sistema, d.cantidad_fisica, d.diferencia
                    FROM detalle_conteo_inicial d
                    JOIN conteo_inicial_diario c ON d.idconteo = c.idconteo
                    WHERE c.codsucursal = ? AND d.codproducto = ? AND c.fechaconteo < ?
                    ORDER BY c.fechaconteo DESC LIMIT 1";
        $stmtP = $this->dbh->prepare($sqlPrev);
        $stmtP->execute([$codsucursal, $codproducto, $fechaConteoActual]);
        $prev = $stmtP->fetch(PDO::FETCH_ASSOC);

        $fechaDesde = $prev ? $prev['fechaconteo'] : date('Y-m-d H:i:s', strtotime($fechaConteoActual . ' -24 hours'));
        $fechaHasta = $fechaConteoActual;
        $horasIntervalo = round((strtotime($fechaHasta) - strtotime($fechaDesde)) / 3600, 1);

        // 2. Buscar turnos / arqueos activos en esa ventana de tiempo
        $sqlArqueos = "SELECT a.codarqueo, a.codcaja, c.nomcaja, COALESCE(u.nombres, u.usuario, 'Cajero') AS cajero, a.fechaapertura, a.fechacierre, a.statusarqueo
                       FROM arqueocaja a
                       JOIN cajas c ON a.codcaja = c.codcaja
                       LEFT JOIN usuarios u ON c.codigo = u.codigo
                       WHERE c.codsucursal = ?
                       AND c.nomcaja NOT LIKE '%ADM%'
                       AND (
                           (a.fechaapertura BETWEEN ? AND ?)
                           OR (a.fechacierre BETWEEN ? AND ?)
                           OR (a.fechaapertura <= ? AND (a.fechacierre >= ? OR a.fechacierre = '0000-00-00 00:00:00'))
                       )
                       ORDER BY a.fechaapertura ASC";
        $stmtA = $this->dbh->prepare($sqlArqueos);
        $stmtA->execute([$codsucursal, $fechaDesde, $fechaHasta, $fechaDesde, $fechaHasta, $fechaDesde, $fechaHasta]);
        $arqueos = $stmtA->fetchAll(PDO::FETCH_ASSOC);

        $turnosList = [];
        $totalVendidoTurnos = 0.00;
        foreach ($arqueos as $arq) {
            $sqlV = "SELECT COALESCE(SUM(dv.cantventa), 0) AS cant_vendida, COALESCE(SUM(dv.valortotal), 0) AS total_dinero
                     FROM detalleventas dv
                     JOIN ventas v ON dv.codventa = v.codventa
                     WHERE v.codarqueo = ? AND dv.codproducto = ?";
            $stmtV = $this->dbh->prepare($sqlV);
            $stmtV->execute([$arq['codarqueo'], $codproducto]);
            $vData = $stmtV->fetch(PDO::FETCH_ASSOC);

            $cantVend = (float)$vData['cant_vendida'];
            $totalVendidoTurnos += $cantVend;

            $turnosList[] = [
                'codarqueo'     => $arq['codarqueo'],
                'nomcaja'       => $arq['nomcaja'],
                'cajero'        => $arq['cajero'],
                'fechaapertura' => $arq['fechaapertura'],
                'fechacierre'   => ($arq['fechacierre'] != '0000-00-00 00:00:00' ? $arq['fechacierre'] : 'Turno aún abierto'),
                'statusarqueo'  => $arq['statusarqueo'],
                'cant_vendida'  => $cantVend,
                'total_dinero'  => (float)$vData['total_dinero']
            ];
        }

        // 3. Compras registradas en la ventana (para verificar si entró mercadería)
        $sqlC = "SELECT c.idcompra, c.codcompra, c.fecharecepcion, dc.cantcompra, dc.valortotal
                 FROM detallecompras dc
                 JOIN compras c ON dc.codcompra = c.codcompra
                 WHERE c.codsucursal = ? AND dc.codproducto = ?
                 AND c.fecharecepcion BETWEEN ? AND ?";
        $stmtC = $this->dbh->prepare($sqlC);
        $stmtC->execute([$codsucursal, $codproducto, date('Y-m-d', strtotime($fechaDesde)), date('Y-m-d', strtotime($fechaHasta))]);
        $compras = $stmtC->fetchAll(PDO::FETCH_ASSOC);

        return [
            'conteo_anterior'      => $prev,
            'fecha_desde'          => $fechaDesde,
            'fecha_hasta'          => $fechaHasta,
            'horas_intervalo'      => $horasIntervalo,
            'turnos'               => $turnosList,
            'total_vendido_turnos' => $totalVendidoTurnos,
            'compras_ventana'      => $compras
        ];
    }
}

