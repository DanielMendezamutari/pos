<?php
/**
 * Cron Job: Auditoría Cierre Turno Noche + Apertura Turno Tarde (10:00 AM)
 * Genera 2 PDFs por sucursal (8 PDFs en total) y los despacha al grupo de WhatsApp.
 */

require_once __DIR__ . '/generador_auditoria_turnos_servicio.php';

$service = new AuditoriaService();
$sucursales = $service->obtenerSucursalesAuditables();

$fechaHoy = date('d/m/Y');
$fechaIso = date('Y-m-d');
$dirSalida = __DIR__ . '/reportes_generados/' . $fechaIso . '_noche';
if (!is_dir($dirSalida)) @mkdir($dirSalida, 0777, true);

$colaLocal = dirname(__DIR__) . '/whatsapp_bot/cola_envios';
if (!is_dir($colaLocal)) @mkdir($colaLocal, 0777, true);

echo "========================================================\n";
echo "☀️ AUDITORÍA AUTOMÁTICA TURNO NOCHE -> APERTURA TARDE\n";
echo "📅 Fecha: {$fechaHoy} | Hora: " . date('H:i') . "\n";
echo "========================================================\n\n";

$resumenTexto = "🃏 *REPORTE CONSOLIDADO JOKER - CIERRE NOCHE / MADRUGADA* 🃏\n";
$resumenTexto .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
$resumenTexto .= "📅 *Fecha:* {$fechaHoy} | *Cierre Noche:* 06:00 AM\n";
$resumenTexto .= "🕒 *Emisión:* 10:00 AM | *Relevo:* Turno Tarde\n";
$resumenTexto .= "👤 *Sistema:* Antigravity AI Forensic POS\n\n";
$resumenTexto .= "📊 *ESTADO ECONÓMICO Y CAJAS (NOCHE):*\n";

$enviosQueue = [];

foreach ($sucursales as $suc) {
    $cod = $suc['codsucursal'];
    $nombre = $suc['nomsucursal'];
    $slug = strtolower(preg_replace('/[^a-zA-Z0-9]/', '_', $nombre));

    $arq = $service->obtenerUltimoArqueo($cod);
    $pagos = $arq ? $service->obtenerPagosPorMedio($arq['codarqueo']) : ['efectivo' => 0, 'qr' => 0, 'total' => 0];
    $detProds = $service->obtenerDetalleProductosArqueo($arq['codarqueo'] ?? 0);
    $anomalias = $service->detectarAnomaliasTurno($arq, $detProds);

    $dif = $arq ? floatval($arq['diferencia']) : 0;
    $efectivo = $pagos['efectivo'];
    $qr = $pagos['qr'];
    $icono = (count($anomalias) == 0 && $dif == 0) ? "🟢" : ((count($anomalias) > 0 && $dif == 0) ? "🟡" : "🔴");

    $resumenTexto .= "\n{$icono} *{$nombre}:*\n";
    $resumenTexto .= "  • Recaudación: Bs. " . number_format($efectivo + $qr, 2) . " (EF: " . number_format($efectivo, 2) . " | QR: " . number_format($qr, 2) . ")\n";
    $resumenTexto .= "  • Diferencia de Caja: " . ($dif == 0 ? "Cuadrado exacto ✅" : "Bs. " . number_format($dif, 2)) . "\n";
    $resumenTexto .= "  • 📦 *Productos Vendidos:* {$detProds['total_unidades']} u. (Bs. " . number_format($detProds['total_bs'], 2) . ")\n";

    $partesCat = [];
    foreach ($detProds['resumen_categorias'] as $cat => $val) {
        $partesCat[] = "{$cat}: " . number_format($val['unidades'], 0) . " u.";
    }
    if (!empty($partesCat)) {
        $resumenTexto .= "    _" . implode(" | ", array_slice($partesCat, 0, 3)) . "_\n";
    }

    if (!empty($anomalias)) {
        foreach ($anomalias as $anom) {
            $resumenTexto .= "    ⚠️ *Alerta Forense:* {$anom}\n";
        }
    }

    // 1. Generar PDF de Cuadre Noche
    $pdfCuadrePath = $dirSalida . "/{$slug}_cuadre_noche.pdf";
    $service->generarPdfCuadre($suc, 'Noche', $fechaHoy, $pdfCuadrePath);

    // 2. Generar PDF de Stock Inicio Tarde
    $pdfStockPath = $dirSalida . "/{$slug}_stock_inicio_tarde.pdf";
    $service->generarPdfStock($suc, 'Tarde', $fechaHoy, $pdfStockPath);

    echo "✅ [{$nombre}] Generados:\n   - Cuadre Noche: " . basename($pdfCuadrePath) . "\n   - Stock Inicio Tarde: " . basename($pdfStockPath) . "\n";

    // Preparar para cola de envíos
    $enviosQueue[] = [
        'pdfPath' => $pdfCuadrePath,
        'caption' => "📄 {$nombre} - Cuadre Económico y Stock Turno Noche ({$fechaHoy})"
    ];
    $enviosQueue[] = [
        'pdfPath' => $pdfStockPath,
        'caption' => "📦 {$nombre} - Planilla Oficial Stock para Turno Tarde ({$fechaHoy})"
    ];
}

$resumenTexto .= "\n━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
$resumenTexto .= "📎 _A continuación se adjuntan los 8 reportes oficiales en PDF (Cuadre Económico + Auditoría de Productos + Planilla de Stock para inicio del Turno Tarde)._";

// 1. Encolar el Mensaje Resumen Ejecutivo
$datosMensaje = [
    'texto' => $resumenTexto,
    'creado' => date('Y-m-d H:i:s')
];
file_put_contents($colaLocal . '/envio_01_resumen_' . time() . '.json', json_encode($datosMensaje, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
echo "\n📤 Mensaje resumen consolidado encolado para WhatsApp.\n";

// 2. Encolar los 8 PDFs
$idx = 2;
foreach ($enviosQueue as $env) {
    $prefijo = str_pad($idx, 2, '0', STR_PAD_LEFT);
    $datosPdf = [
        'pdfPath' => realpath($env['pdfPath']),
        'caption' => $env['caption'],
        'creado' => date('Y-m-d H:i:s')
    ];
    file_put_contents($colaLocal . "/envio_{$prefijo}_pdf_" . time() . "_{$idx}.json", json_encode($datosPdf, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    $idx++;
}

echo "📄 8 Documentos PDF encolados exitosamente en la cola de WhatsApp ({$colaLocal}).\n";
echo "🚀 El bot despachará todos los informes al grupo 'Reportes Auditoría Joker'.\n";
