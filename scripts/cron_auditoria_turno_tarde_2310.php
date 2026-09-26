<?php
/**
 * Cron Job: Auditoría Cierre Turno Tarde + Apertura Turno Noche (23:10)
 * Genera 2 PDFs por sucursal (8 PDFs en total) y los despacha al grupo de WhatsApp.
 */

require_once __DIR__ . '/generador_auditoria_turnos_servicio.php';

$service = new AuditoriaService();
$sucursales = $service->obtenerSucursalesAuditables();

$fechaHoy = date('d/m/Y');
$fechaIso = date('Y-m-d');
$dirSalida = __DIR__ . '/reportes_generados/' . $fechaIso . '_tarde';
if (!is_dir($dirSalida)) @mkdir($dirSalida, 0777, true);

$colaLocal = dirname(__DIR__) . '/whatsapp_bot/cola_envios';
if (!is_dir($colaLocal)) @mkdir($colaLocal, 0777, true);

echo "========================================================\n";
echo "🌙 AUDITORÍA AUTOMÁTICA TURNO TARDE -> APERTURA NOCHE\n";
echo "📅 Fecha: {$fechaHoy} | Hora: " . date('H:i') . "\n";
echo "========================================================\n\n";

$resumenTexto = "🃏 *REPORTE CONSOLIDADO JOKER - CIERRE TARDE* 🃏\n";
$resumenTexto .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
$resumenTexto .= "📅 *Fecha:* {$fechaHoy} | *Cierre Tarde:* 23:00\n";
$resumenTexto .= "🕒 *Emisión:* " . date('H:i') . " | *Relevo:* Turno Noche\n\n";
$resumenTexto .= "📊 *ESTADO ECONÓMICO DE LAS 4 CASAS:*\n";

$enviosQueue = [];

foreach ($sucursales as $suc) {
    $cod = $suc['codsucursal'];
    $nombre = $suc['nomsucursal'];
    $slug = strtolower(preg_replace('/[^a-zA-Z0-9]/', '_', $nombre));

    $arq = $service->obtenerUltimoArqueo($cod);
    $pagos = $arq ? $service->obtenerPagosPorMedio($arq['codarqueo']) : ['efectivo' => 0, 'qr' => 0, 'total' => 0];

    $dif = $arq ? floatval($arq['diferencia']) : 0;
    $efectivo = $pagos['efectivo'];
    $qr = $pagos['qr'];
    $icono = ($dif == 0) ? "🟢" : (($dif > 0) ? "🟡" : "🔴");

    $resumenTexto .= "\n{$icono} *{$nombre}:*\n";
    $resumenTexto .= "  • Ventas: Bs. " . number_format($efectivo + $qr, 2) . " (EF: " . number_format($efectivo, 2) . " | QR: " . number_format($qr, 2) . ")\n";
    $resumenTexto .= "  • Diferencia de Caja: " . ($dif == 0 ? "Cuadrado exacto ✅" : "Bs. " . number_format($dif, 2)) . "\n";

    // Control de Stock y Productos a Cuadrar
    $disc = $service->obtenerDiscrepanciasStockYProductos($cod, $arq['codarqueo'] ?? 0, $fechaIso);
    if ($disc['estado'] === 'DISCREPANCIAS_DETECTADAS') {
        $resumenTexto .= "  🔍 *Mermas / Productos a cuadrar:*\n";
        if (!empty($disc['faltantes'])) {
            $totalF = count($disc['faltantes']);
            $mostrados = array_slice($disc['faltantes'], 0, 5);
            foreach ($mostrados as $f) {
                $resumenTexto .= "     🔴 Faltante: " . trim($f['producto']) . " (" . number_format($f['diferencia'], 0) . " u.) - Bs. " . number_format($f['costo_total'], 2) . "\n";
            }
            if ($totalF > 5) {
                $resumenTexto .= "     _... y " . ($totalF - 5) . " mermas menores más (ver informe PDF)._\n";
            }
        }
        if (!empty($disc['sobrantes'])) {
            foreach (array_slice($disc['sobrantes'], 0, 2) as $s) {
                $resumenTexto .= "     🟡 Sobrante: " . trim($s['producto']) . " (+" . number_format($s['diferencia'], 0) . " u.)\n";
            }
        }
    } elseif ($disc['estado'] === 'CUADRADO_EXACTO') {
        $resumenTexto .= "  📦 Stock: Cuadrado exacto (Sin faltantes) ✅\n";
    } else {
        $resumenTexto .= "  📦 Stock: ⏳ Sin conteo físico registrado en este turno\n";
    }

    // 1. Generar ÚNICO PDF de Cuadre y Mermas
    $pdfCuadrePath = $dirSalida . "/{$slug}_auditoria_tarde.pdf";
    $service->generarPdfCuadre($suc, 'Tarde', $fechaHoy, $pdfCuadrePath);

    echo "✅ [{$nombre}] Generado informe de auditoría: " . basename($pdfCuadrePath) . "\n";

    // Preparar para cola de envíos (Solo 1 PDF ejecutivo por casa)
    $enviosQueue[] = [
        'pdfPath' => $pdfCuadrePath,
        'caption' => "📄 {$nombre} - Cuadre y Control de Mermas Turno Tarde ({$fechaHoy})"
    ];
}

$resumenTexto .= "\n━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
$resumenTexto .= "📎 _A continuación se adjuntan los 4 reportes oficiales en PDF (1 por cada casa: Cuadre Financiero y Control de Mermas)._";

// 1. Encolar el Mensaje Resumen Ejecutivo
$datosMensaje = [
    'texto' => $resumenTexto,
    'creado' => date('Y-m-d H:i:s')
];
file_put_contents($colaLocal . '/envio_01_resumen_' . time() . '.json', json_encode($datosMensaje, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
echo "\n📤 Mensaje resumen consolidado encolado para WhatsApp.\n";

// 2. Encolar los 4 PDFs
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

echo "📄 4 Documentos PDF encolados exitosamente en la cola de WhatsApp ({$colaLocal}).\n";
echo "🚀 El bot despachará todos los informes al grupo 'Reportes Auditoría Joker'.\n";
