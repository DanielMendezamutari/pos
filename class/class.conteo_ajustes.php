<?php
/**
 * Servicio de Dominio para Ajuste y Cuadre de Inventario desde Conteos Iniciales Diarios
 * Cumple con principios SOLID (Responsabilidad Única, Inversión de Dependencias, Alta Cohesión)
 */

require_once("classconexion.php");

class ConteoAjusteService {

    private $dbh;

    public function __construct($dbh = null) {
        if ($dbh instanceof PDO) {
            $this->dbh = $dbh;
        } else {
            $db = new Db();
            // Acceder a la conexión PDO a través de una instancia que extienda Db
            $reflector = new ReflectionClass('Db');
            if ($reflector->hasProperty('dbh')) {
                $prop = $reflector->getProperty('dbh');
                $prop->setAccessible(true);
                $this->dbh = $prop->getValue($db);
            }
        }
    }

    /**
     * Ajusta un ítem individual del conteo físico
     *
     * @param int $iddetalleconteo ID del detalle de conteo
     * @param string $motivo Motivo o justificación del ajuste
     * @param int $codusuario ID del usuario autenticado que autoriza
     * @param string $nomusuario Nombre del usuario que autoriza
     * @return array Resultado de la operación con status y mensaje
     */
    public function ajustarItemIndividual($iddetalleconteo, $motivo = "", $codusuario = 0, $nomusuario = "Administrador") {
        $iddetalleconteo = (int)$iddetalleconteo;
        if ($iddetalleconteo <= 0) {
            return array("status" => 0, "msg" => "Identificador de ítem de conteo inválido.");
        }

        try {
            // Consultar datos del detalle del conteo y su producto en la sucursal correspondiente
            $sqlDet = "SELECT 
                dci.*, 
                cid.idconteo,
                cid.codsucursal,
                COALESCE(p.existencia, 0) AS stock_sistema,
                p.codproducto AS codigo_prod_bd,
                p.producto AS nom_prod_bd,
                COALESCE(p.preciocompra, 0.00) AS preciocompra,
                COALESCE(p.precioxpublico, 0.00) AS precioxpublico,
                COALESCE(p.ivaproducto, 'NO') AS ivaproducto,
                COALESCE(p.descproducto, 0.00) AS descproducto
                FROM detalle_conteo_inicial dci
                INNER JOIN conteo_inicial_diario cid ON dci.idconteo = cid.idconteo
                LEFT JOIN productos p ON (dci.idproducto = p.idproducto AND p.codsucursal = cid.codsucursal)
                WHERE dci.iddetalleconteo = ?
                LIMIT 1";

            $stmtDet = $this->dbh->prepare($sqlDet);
            $stmtDet->execute(array($iddetalleconteo));
            $item = $stmtDet->fetch(PDO::FETCH_ASSOC);

            if (!$item) {
                return array("status" => 0, "msg" => "No se encontró el registro del conteo.");
            }

            if (!empty($item['ajustado']) && (int)$item['ajustado'] === 1) {
                return array("status" => 0, "msg" => "Este producto ya fue ajustado y sincronizado previamente.");
            }

            $cantidad_fisica = (float)$item['cantidad_fisica'];
            $stock_sistema = (float)$item['stock_sistema'];
            $diferencia = $cantidad_fisica - $stock_sistema;

            if (abs($diferencia) < 0.0001) {
                // Ya cuadra exactamente
                $this->marcarDetalleAjustado($iddetalleconteo, $motivo ?: "Stock ya se encontraba cuadrado con conteo físico", $nomusuario);
                return array("status" => 1, "msg" => "El producto ya se encontraba cuadrado con el conteo físico.", "diferencia" => 0);
            }

            $this->dbh->beginTransaction();

            $idconteo = (int)$item['idconteo'];
            $codsucursal = (int)$item['codsucursal'];
            $idproducto = (int)$item['idproducto'];
            $codproducto = !empty($item['codproducto']) ? $item['codproducto'] : $item['codigo_prod_bd'];
            $folioFormat = "#" . str_pad($idconteo, 5, "0", STR_PAD_LEFT);

            // 1. Actualizar la existencia en la tabla productos para que sea exactamente la cantidad física contada
            $sqlUpdStock = "UPDATE productos SET existencia = ? WHERE idproducto = ? AND codsucursal = ?";
            $stmtUpdStock = $this->dbh->prepare($sqlUpdStock);
            $stmtUpdStock->execute(array($cantidad_fisica, $idproducto, $codsucursal));

            // 2. Registrar movimiento en KARDEX para auditoría y trazabilidad
            $this->registrarMovimientoKardex(
                $codsucursal,
                $idconteo,
                $codproducto,
                $stock_sistema,
                $cantidad_fisica,
                $diferencia,
                $item['preciocompra'],
                $item['ivaproducto'],
                $item['descproducto'],
                $codusuario,
                $folioFormat,
                $motivo
            );

            // 3. Marcar detalle como ajustado
            $fecha_ajuste = date("Y-m-d H:i:s");
            $sqlUpdDet = "UPDATE detalle_conteo_inicial SET 
                ajustado = 1, 
                fecha_ajuste = ?, 
                motivo_ajuste = ?, 
                usuario_ajuste = ? 
                WHERE iddetalleconteo = ?";
            $stmtUpdDet = $this->dbh->prepare($sqlUpdDet);
            $stmtUpdDet->execute(array($fecha_ajuste, $motivo, $nomusuario, $iddetalleconteo));

            $this->dbh->commit();

            $tipoTexto = $diferencia > 0 ? "Sobrante (+".number_format($diferencia, 0).")" : "Faltante (".number_format($diferencia, 0).")";
            return array(
                "status" => 1,
                "msg" => "¡Ajuste aplicado con éxito! Se cuadró el $tipoTexto para " . htmlspecialchars($item['producto']) . ". Nuevo stock: " . number_format($cantidad_fisica, 0),
                "nuevo_stock" => $cantidad_fisica,
                "diferencia" => $diferencia
            );

        } catch (Exception $e) {
            if ($this->dbh->inTransaction()) {
                $this->dbh->rollBack();
            }
            error_log("Error en ConteoAjusteService::ajustarItemIndividual: " . $e->getMessage());
            return array("status" => 0, "msg" => "Error interno al procesar el ajuste: " . $e->getMessage());
        }
    }

    /**
     * Ajusta en lote todos los productos con sobrante de un conteo
     *
     * @param int $idconteo ID del conteo
     * @param string $motivo Motivo o justificación del ajuste
     * @param int $codusuario ID del usuario
     * @param string $nomusuario Nombre del usuario
     * @return array Resumen de la operación
     */
    public function ajustarSobrantesLote($idconteo, $motivo = "", $codusuario = 0, $nomusuario = "Administrador") {
        return $this->ajustarLotePorCondicion($idconteo, "sobrantes", $motivo, $codusuario, $nomusuario);
    }

    /**
     * Ajusta en lote todas las discrepancias (sobrantes y faltantes) de un conteo
     *
     * @param int $idconteo ID del conteo
     * @param string $motivo Motivo o justificación
     * @param int $codusuario ID del usuario
     * @param string $nomusuario Nombre del usuario
     * @return array Resumen de la operación
     */
    public function ajustarTodosLote($idconteo, $motivo = "", $codusuario = 0, $nomusuario = "Administrador") {
        return $this->ajustarLotePorCondicion($idconteo, "todos", $motivo, $codusuario, $nomusuario);
    }

    /**
     * Proceso unificado para ajuste masivo en transacción PDO
     */
    private function ajustarLotePorCondicion($idconteo, $filtro = "sobrantes", $motivo = "", $codusuario = 0, $nomusuario = "Administrador") {
        $idconteo = (int)$idconteo;
        if ($idconteo <= 0) {
            return array("status" => 0, "msg" => "ID de conteo inválido.");
        }

        try {
            $sqlItems = "SELECT 
                dci.*, 
                cid.codsucursal,
                COALESCE(p.existencia, 0) AS stock_sistema,
                p.codproducto AS codigo_prod_bd,
                COALESCE(p.preciocompra, 0.00) AS preciocompra,
                COALESCE(p.ivaproducto, 'NO') AS ivaproducto,
                COALESCE(p.descproducto, 0.00) AS descproducto
                FROM detalle_conteo_inicial dci
                INNER JOIN conteo_inicial_diario cid ON dci.idconteo = cid.idconteo
                LEFT JOIN productos p ON (dci.idproducto = p.idproducto AND p.codsucursal = cid.codsucursal)
                WHERE dci.idconteo = ? AND COALESCE(dci.ajustado, 0) = 0";

            $stmtItems = $this->dbh->prepare($sqlItems);
            $stmtItems->execute(array($idconteo));
            $items = $stmtItems->fetchAll(PDO::FETCH_ASSOC);

            if (empty($items)) {
                return array("status" => 0, "msg" => "No hay productos pendientes por ajustar en este conteo.");
            }

            $itemsParaAjustar = array();
            foreach ($items as $it) {
                $cant_fisica = (float)$it['cantidad_fisica'];
                $stock_sis = (float)$it['stock_sistema'];
                $dif = $cant_fisica - $stock_sis;

                if ($filtro === "sobrantes" && $dif > 0.0001) {
                    $itemsParaAjustar[] = array('item' => $it, 'dif' => $dif);
                } elseif ($filtro === "todos" && abs($dif) > 0.0001) {
                    $itemsParaAjustar[] = array('item' => $it, 'dif' => $dif);
                }
            }

            if (empty($itemsParaAjustar)) {
                return array("status" => 0, "msg" => "No se encontraron discrepancias del tipo seleccionado para ajustar.");
            }

            $this->dbh->beginTransaction();

            $totalAjustados = 0;
            $folioFormat = "#" . str_pad($idconteo, 5, "0", STR_PAD_LEFT);
            $fecha_ajuste = date("Y-m-d H:i:s");

            $sqlUpdStock = "UPDATE productos SET existencia = ? WHERE idproducto = ? AND codsucursal = ?";
            $stmtUpdStock = $this->dbh->prepare($sqlUpdStock);

            $sqlUpdDet = "UPDATE detalle_conteo_inicial SET 
                ajustado = 1, 
                fecha_ajuste = ?, 
                motivo_ajuste = ?, 
                usuario_ajuste = ? 
                WHERE iddetalleconteo = ?";
            $stmtUpdDet = $this->dbh->prepare($sqlUpdDet);

            foreach ($itemsParaAjustar as $reg) {
                $it = $reg['item'];
                $dif = $reg['dif'];
                $cant_fisica = (float)$it['cantidad_fisica'];
                $stock_sis = (float)$it['stock_sistema'];
                $idprod = (int)$it['idproducto'];
                $codsuc = (int)$it['codsucursal'];
                $codprod = !empty($it['codproducto']) ? $it['codproducto'] : $it['codigo_prod_bd'];

                // Actualizar stock
                $stmtUpdStock->execute(array($cant_fisica, $idprod, $codsuc));

                // Registrar en Kardex
                $this->registrarMovimientoKardex(
                    $codsuc,
                    $idconteo,
                    $codprod,
                    $stock_sis,
                    $cant_fisica,
                    $dif,
                    $it['preciocompra'],
                    $it['ivaproducto'],
                    $it['descproducto'],
                    $codusuario,
                    $folioFormat,
                    $motivo
                );

                // Marcar como ajustado
                $stmtUpdDet->execute(array($fecha_ajuste, $motivo, $nomusuario, (int)$it['iddetalleconteo']));
                $totalAjustados++;
            }

            $this->dbh->commit();

            return array(
                "status" => 1,
                "total_ajustados" => $totalAjustados,
                "msg" => "¡Se ajustaron y cuadraron con éxito $totalAjustados productos en el inventario del sistema!"
            );

        } catch (Exception $e) {
            if ($this->dbh->inTransaction()) {
                $this->dbh->rollBack();
            }
            error_log("Error en ConteoAjusteService::ajustarLotePorCondicion: " . $e->getMessage());
            return array("status" => 0, "msg" => "Error interno al procesar el ajuste masivo: " . $e->getMessage());
        }
    }

    /**
     * Inserta registro detallado en KARDEX para auditoría
     */
    private function registrarMovimientoKardex($codsucursal, $idconteo, $codproducto, $stock_anterior, $stock_nuevo, $diferencia, $preciocompra, $ivaproducto, $descproducto, $codusuario, $folioFormat, $motivo = "") {
        $queryKardex = "INSERT INTO kardex VALUES (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmtKardex = $this->dbh->prepare($queryKardex);

        $esSobrante = ($diferencia > 0);
        $movimiento = $esSobrante ? "ENTRADAS" : "SALIDAS";
        $entradas = $esSobrante ? abs($diferencia) : "0.00";
        $salidas = $esSobrante ? "0.00" : abs($diferencia);
        $devolucion = "0.00";
        $stockactual = $stock_nuevo;
        $precio = !empty($preciocompra) ? (float)$preciocompra : 0.00;
        $iva = ($ivaproducto == 'SI') ? 16.00 : 0.00;
        $desc = !empty($descproducto) ? (float)$descproducto : 0.00;

        $tipoDoc = $esSobrante ? "AJUSTE POR SOBRANTE" : "AJUSTE POR FALTANTE";
        $motivoTexto = !empty($motivo) ? " | Motivo: " . $motivo : "";
        $documento = "CONTEO INICIAL $folioFormat ($tipoDoc)$motivoTexto";
        $fechakardex = date("Y-m-d");
        $tipokardex = "1";
        $procedimiento = "1";

        $codproceso = (string)$idconteo;
        $codresponsable = "0";

        $stmtKardex->execute(array(
            $codproceso,
            $codresponsable,
            $codproducto,
            $movimiento,
            $entradas,
            $salidas,
            $devolucion,
            $stockactual,
            $iva,
            $desc,
            $precio,
            $documento,
            $fechakardex,
            $tipokardex,
            $procedimiento,
            $codsucursal,
            $codusuario
        ));
    }

    /**
     * Marca un detalle como ajustado sin mover stock (ej: si ya cuadraba)
     */
    private function marcarDetalleAjustado($iddetalleconteo, $motivo, $nomusuario) {
        $sql = "UPDATE detalle_conteo_inicial SET ajustado = 1, fecha_ajuste = NOW(), motivo_ajuste = ?, usuario_ajuste = ? WHERE iddetalleconteo = ?";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array($motivo, $nomusuario, $iddetalleconteo));
    }

    /**
     * Obtiene el detalle completo y trazabilidad de productos ajustados para un conteo
     *
     * @param int $idconteo
     * @return array Cabecera, lista de ítems ajustados y resumen de totales
     */
    public function obtenerHistorialAjustesConteo($idconteo) {
        $idconteo = (int)$idconteo;
        if ($idconteo <= 0) {
            return array('cabecera' => null, 'ajustados' => array(), 'totales' => array('items' => 0, 'sobrantes_unidades' => 0, 'faltantes_unidades' => 0));
        }

        // Cabecera del conteo
        $sqlCab = "SELECT 
            cid.*,
            s.cuitsucursal,
            s.nomsucursal,
            s.direcsucursal,
            s.tlfsucursal,
            u.nombres AS nomusuario
            FROM conteo_inicial_diario cid
            INNER JOIN sucursales s ON cid.codsucursal = s.codsucursal
            LEFT JOIN usuarios u ON cid.codusuario = u.codigo
            WHERE cid.idconteo = ?
            LIMIT 1";
        $stmtCab = $this->dbh->prepare($sqlCab);
        $stmtCab->execute(array($idconteo));
        $cabecera = $stmtCab->fetch(PDO::FETCH_ASSOC);

        if (!$cabecera) {
            return array('cabecera' => null, 'ajustados' => array(), 'totales' => array('items' => 0, 'sobrantes_unidades' => 0, 'faltantes_unidades' => 0));
        }

        // Ítems ajustados
        $sqlDet = "SELECT 
            dci.*,
            COALESCE(k.movimiento, '') AS kardex_movimiento,
            COALESCE(k.entradas, 0.00) AS kardex_entradas,
            COALESCE(k.salidas, 0.00) AS kardex_salidas,
            COALESCE(k.stockactual, dci.cantidad_fisica) AS stock_resultante,
            COALESCE(k.documento, '') AS kardex_documento
            FROM detalle_conteo_inicial dci
            LEFT JOIN kardex k ON (
                k.codproceso = ? 
                AND k.codproducto = dci.codproducto 
                AND k.codsucursal = ?
                AND k.documento LIKE '%CONTEO INICIAL%'
            )
            WHERE dci.idconteo = ? AND dci.ajustado = 1
            ORDER BY dci.iddetalleconteo ASC";

        $codsuc = (int)$cabecera['codsucursal'];
        $stmtDet = $this->dbh->prepare($sqlDet);
        $stmtDet->execute(array((string)$idconteo, $codsuc, $idconteo));
        $rawItems = $stmtDet->fetchAll(PDO::FETCH_ASSOC);

        $ajustados = array();
        $totalSobrantesUnid = 0;
        $totalFaltantesUnid = 0;

        foreach ($rawItems as $row) {
            $entradas = (float)$row['kardex_entradas'];
            $salidas = (float)$row['kardex_salidas'];
            $cantFis = (float)$row['cantidad_fisica'];

            if ($entradas > 0) {
                $tipoAjuste = "SOBRANTE";
                $unidadesAjuste = $entradas;
                $txtAjuste = "+" . number_format($entradas, 0) . " u. (Sobr)";
                $totalSobrantesUnid += $entradas;
            } elseif ($salidas > 0) {
                $tipoAjuste = "FALTANTE";
                $unidadesAjuste = $salidas;
                $txtAjuste = "-" . number_format($salidas, 0) . " u. (Falt)";
                $totalFaltantesUnid += $salidas;
            } else {
                $tipoAjuste = "CUADRADO";
                $unidadesAjuste = 0;
                $txtAjuste = "Cuadrado";
            }

            $row['tipo_ajuste'] = $tipoAjuste;
            $row['unidades_ajuste'] = $unidadesAjuste;
            $row['txt_ajuste'] = $txtAjuste;
            $row['stock_resultante'] = (float)$row['stock_resultante'];

            $ajustados[] = $row;
        }

        return array(
            'cabecera' => $cabecera,
            'ajustados' => $ajustados,
            'totales' => array(
                'items' => count($ajustados),
                'sobrantes_unidades' => $totalSobrantesUnid,
                'faltantes_unidades' => $totalFaltantesUnid
            )
        );
    }
}

