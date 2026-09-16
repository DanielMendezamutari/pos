<?php
/**
 * Script Profesional de Auditoría Forense y Cierre para el Skill 'pos-auditoria-turnos'
 * Soporta todas las sucursales:
 *   1: JOKER MEGA
 *   2: JOKER CENTRAL
 *   3: JOKER ULTRA
 *   4: JOKER EXPRESS
 *   all: Todas las sucursales
 *
 * Uso CLI:
 *   php auditar_rango.php <codsucursal> <fecha_inicio> <fecha_fin> [--pdf]
 * Ejemplo:
 *   php auditar_rango.php 3 2026-08-16 2026-09-12 --pdf
 */

if (php_sapi_name() !== 'cli') {
    die("Solo ejecutable desde CLI.\n");
}

$codsucursal = isset($argv[1]) ? $argv[1] : 3;
$fechaInicio = isset($argv[2]) ? $argv[2] : date('Y-m-01');
$fechaFin    = isset($argv[3]) ? $argv[3] : date('Y-m-d');
$generarPdf  = in_array('--pdf', $argv);

require_once(__DIR__ . "/../../../../class/classconexion.php");

$db = new Db();
$ref = new ReflectionClass('Db');
$prop = $ref->getProperty('dbh');
$prop->setAccessible(true);
$dbh = $prop->getValue($db);

// Sucursales mapping
$stmtS = $dbh->query("SELECT codsucursal, nomsucursal FROM sucursales");
$sucursalesMap = $stmtS->fetchAll(PDO::FETCH_KEY_PAIR);

$targetSucursales = ($codsucursal === 'all') ? array_keys($sucursalesMap) : [(int)$codsucursal];

foreach ($targetSucursales as $sucId) {
    $nomSucursal = $sucursalesMap[$sucId] ?? "SUCURSAL $sucId";
    
    echo "=========================================================================\n";
    echo "   AUDITORÍA INTEGRAL DE SUCURSAL: $nomSucursal (ID: $sucId)\n";
    echo "   Período: $fechaInicio al $fechaFin\n";
    echo "=========================================================================\n\n";

    // 1. Arqueos de la sucursal
    $sqlArq = "SELECT 
        a.codarqueo, a.codcaja, c.nomcaja, a.fechaapertura, a.fechacierre,
        a.efectivocaja, a.dineroefectivo, a.diferencia AS dif_efectivo, a.comentarios,
        TIMESTAMPDIFF(MINUTE, a.fechaapertura, a.fechacierre) as duracion_min
    FROM arqueocaja a
    INNER JOIN cajas c ON a.codcaja = c.codcaja
    WHERE c.codsucursal = :sucId
      AND (DATE(a.fechaapertura) BETWEEN :inicio1 AND :fin1 OR DATE(a.fechacierre) BETWEEN :inicio2 AND :fin2)
    ORDER BY a.fechaapertura ASC";

    $stmt = $dbh->prepare($sqlArq);
    $stmt->execute([
        ':sucId' => $sucId, 
        ':inicio1' => $fechaInicio, 
        ':fin1' => $fechaFin,
        ':inicio2' => $fechaInicio, 
        ':fin2' => $fechaFin
    ]);
    $arqueos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($arqueos)) {
        echo "No se encontraron arqueos en este rango para $nomSucursal.\n\n";
        continue;
    }

    $totalVentasEf = 0;
    $totalVentasQr = 0;
    $totalFaltanteInjustificado = 0;
    $totalPagosEnComentarios = 0;
    $turnosCargaBloque = 0;

    $listaInjustificados = [];
    $listaPagosPersonal = [];

    foreach ($arqueos as $a) {
        $codarqueo = $a['codarqueo'];

        // Pagos en este arqueo
        $sqlPagos = "SELECT mp.mediopago, COALESCE(SUM(mpv.montopagado), 0) AS monto
                     FROM mediospagoxventas mpv
                     INNER JOIN mediospagos mp ON mpv.codmediopago = mp.codmediopago
                     WHERE mpv.codarqueo = :codarqueo
                     GROUP BY mp.mediopago";
        $stmtP = $dbh->prepare($sqlPagos);
        $stmtP->execute([':codarqueo' => $codarqueo]);
        $pagos = $stmtP->fetchAll(PDO::FETCH_KEY_PAIR);

        $efPos = (float)($pagos['EFECTIVO'] ?? 0);
        $qrPos = (float)($pagos['QR'] ?? 0);
        $totalVentasEf += $efPos;
        $totalVentasQr += $qrPos;

        // Detección de carga en bloque (caja abierta menos de 45 min pero con ventas cargadas)
        if ($a['duracion_min'] !== null && $a['duracion_min'] <= 45 && ($efPos + $qrPos) > 0) {
            $turnosCargaBloque++;
        }

        $dif = (float)$a['dif_efectivo'];
        if ($dif < 0) {
            $com = trim($a['comentarios'] ?? '');
            if (!empty($com) && preg_match('/pago|personal|meser|reemplazo|adelanto|sen/i', $com)) {
                $totalPagosEnComentarios += abs($dif);
                $listaPagosPersonal[] = [
                    'arqueo' => $codarqueo,
                    'caja' => $a['nomcaja'],
                    'fecha' => $a['fechacierre'],
                    'monto' => abs($dif),
                    'comentario' => $com
                ];
            } else {
                $totalFaltanteInjustificado += abs($dif);
                $listaInjustificados[] = [
                    'arqueo' => $codarqueo,
                    'caja' => $a['nomcaja'],
                    'fecha' => $a['fechacierre'],
                    'monto' => abs($dif),
                    'comentario' => $com
                ];
            }
        }
    }

    $totalRecaudacion = $totalVentasEf + $totalVentasQr;

    echo "--- RESUMEN RECAUDACIÓN ---\n";
    echo sprintf("Total Turnos: %d | Ventas Totales: Bs %.2f\n", count($arqueos), $totalRecaudacion);
    echo sprintf("  -> Efectivo: Bs %.2f (%.1f%%)\n", $totalVentasEf, $totalRecaudacion > 0 ? ($totalVentasEf / $totalRecaudacion * 100) : 0);
    echo sprintf("  -> QR:       Bs %.2f (%.1f%%)\n\n", $totalVentasQr, $totalRecaudacion > 0 ? ($totalVentasQr / $totalRecaudacion * 100) : 0);

    echo "--- DESGLOSE DE DESCUADRES DE EFECTIVO ---\n";
    echo sprintf("1. Faltantes Netos Injustificados (a descontar de sueldo): Bs %.2f\n", $totalFaltanteInjustificado);
    foreach ($listaInjustificados as $item) {
        echo sprintf("   • Arqueo #%d (%s - %s): -Bs %.2f %s\n", 
            $item['arqueo'], $item['caja'], $item['fecha'], $item['monto'], 
            $item['comentario'] ? "(\"{$item['comentario']}\")" : "[SIN JUSTIFICAR]");
    }

    echo sprintf("\n2. Salidas para Pagos a Personal en Comentarios: Bs %.2f\n", $totalPagosEnComentarios);
    foreach ($listaPagosPersonal as $item) {
        echo sprintf("   • Arqueo #%d (%s - %s): -Bs %.2f -> \"%s\"\n", 
            $item['arqueo'], $item['caja'], $item['fecha'], $item['monto'], $item['comentario']);
    }

    // 2. Inventario Ciego
    echo "\n--- CONTROL DE INVENTARIOS CIEGOS (Relevos) ---\n";
    $sqlStock = "
        SELECT d.idproducto, p.producto, p.preciocompra, p.precioxpublico,
               SUM(CASE WHEN d.diferencia < 0 THEN d.diferencia ELSE 0 END) as faltantes,
               SUM(CASE WHEN d.diferencia > 0 THEN d.diferencia ELSE 0 END) as sobrantes,
               COUNT(DISTINCT c.idconteo) as conteos_con_dif
        FROM detalle_conteo_inicial d
        JOIN conteo_inicial_diario c ON d.idconteo = c.idconteo
        LEFT JOIN productos p ON d.idproducto = p.idproducto
        WHERE c.codsucursal = :sucId
          AND DATE(c.fechaconteo) BETWEEN :inicio AND :fin
        GROUP BY d.idproducto, p.producto, p.preciocompra, p.precioxpublico
        HAVING faltantes < 0
        ORDER BY faltantes ASC LIMIT 10";
    $stmtS = $dbh->prepare($sqlStock);
    $stmtS->execute([':sucId' => $sucId, ':inicio' => $fechaInicio, ':fin' => $fechaFin]);
    $stockRows = $stmtS->fetchAll(PDO::FETCH_ASSOC);

    if (empty($stockRows)) {
        echo "✓ No se registran diferencias negativas en inventarios de relevo.\n";
    } else {
        echo "Productos con faltantes reportados en el período:\n";
        foreach ($stockRows as $sr) {
            echo sprintf("   • %-25s | Faltante Acum: %4.0f uds | Costo: Bs %6.2f | P.Venta: Bs %6.2f\n",
                substr($sr['producto'], 0, 25), $sr['faltantes'], $sr['preciocompra'], $sr['precioxpublico']);
        }
    }

    echo "\n--- ANOMALÍAS OPERATIVAS ---\n";
    echo sprintf("• Turnos con ventas cargadas 'en bloque' al cierre: %d de %d turnos\n", $turnosCargaBloque, count($arqueos));
    
    // Check egresos
    $stmtE = $dbh->prepare("SELECT COUNT(*) FROM movimientoscajas WHERE codsucursal = :sucId AND DATE(fechamovimiento) BETWEEN :inicio AND :fin");
    $stmtE->execute([':sucId' => $sucId, ':inicio' => $fechaInicio, ':fin' => $fechaFin]);
    $egresosCount = (int)$stmtE->fetchColumn();
    echo sprintf("• Movimientos formales de caja registrados en sistema: %d (Alerta si es 0 y hubo retiros)\n", $egresosCount);

    echo "\n-------------------------------------------------------------------------\n";
    echo sprintf("DICTAMEN FINAL SUCURSAL %s:\n", strtoupper($nomSucursal));
    echo sprintf("  -> Faltante Líquido a Descontar:     Bs %.2f\n", $totalFaltanteInjustificado);
    echo sprintf("  -> Salidas de Caja a Cruzar Nómina:  Bs %.2f\n", $totalPagosEnComentarios);
    echo "-------------------------------------------------------------------------\n\n";

    if ($generarPdf) {
        $pdfScript = __DIR__ . '/../../../../scripts/generar_pdf_auditoria_ultra.php';
        if (file_exists($pdfScript) && $sucId === 3) {
            exec("php " . escapeshellarg($pdfScript));
            echo "✓ Reporte PDF oficial generado: informe_auditoria_sucursal_ultra.pdf\n\n";
        }
    }
}
