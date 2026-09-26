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

$resumenTexto = "🃏 *REPORTE DE AUDITORÍA - CIERRE TURNO NOCHE*\n";
$resumenTexto .= "📅 *Fecha:* {$fechaHoy} | *Cierre:* 06:00 AM | *Relevo:* Turno Tarde\n";
$resumenTexto .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";

$enviosQueue = [];
$num = 1;

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
    $totalRecaudado = $efectivo + $qr;

    $estadoCaja = "";
    if ($dif == 0) {
        $estadoCaja = "Cuadrado exacto (Sin faltantes) ✅";
    } elseif ($dif < 0) {
        $estadoCaja = "FALTANTE DE Bs. " . number_format(abs($dif), 2) . " 🔴";
    } else {
        $estadoCaja = "SOBRANTE DE +Bs. " . number_format($dif, 2) . " 🟡";
    }

    $resumenTexto .= "\n🏢 *{$num}. {$nombre}*\n";
    $resumenTexto .= "💰 *Total Recaudado:* Bs. " . number_format($totalRecaudado, 2) . "\n";
    $resumenTexto .= "   • Efectivo en caja: Bs. " . number_format($efectivo, 2) . "\n";
    $resumenTexto .= "   • Cobros QR / Banco: Bs. " . number_format($qr, 2) . "\n";
    $resumenTexto .= "💵 *Caja:* {$estadoCaja}\n";

    if (!empty($detProds['total_billar_bs']) && $detProds['total_billar_bs'] > 0) {
        $resumenTexto .= "🎱 *Mesas de Billar:* Bs. " . number_format($detProds['total_billar_bs'], 2) . "\n";
    }

    // Resumen claro de productos vendidos
    $lineasProds = [];
    foreach ($detProds['resumen_categorias'] as $cat => $val) {
        if ($cat === 'MESAS DE BILLAR') continue;
        if ($cat === 'CERVEZAS Y COMBOS') {
            $lineasProds[] = "   • Cervezas y Combos: " . number_format($val['unidades'], 0) . " botellas";
        } elseif ($cat === 'SODAS Y AGUAS') {
            $lineasProds[] = "   • Sodas y Aguas: " . number_format($val['unidades'], 0) . " botellas";
        } elseif ($cat === 'GUANTES DE BILLAR') {
            $lineasProds[] = "   • Guantes de billar: " . number_format($val['unidades'], 0) . " pares";
        } elseif ($cat === 'SNACKS Y TABACO') {
            $lineasProds[] = "   • Snacks y Cigarros: " . number_format($val['unidades'], 0) . " unidades";
        } else {
            $lineasProds[] = "   • " . ucfirst(strtolower($cat)) . ": " . number_format($val['unidades'], 0) . " unidades";
        }
    }
    if (!empty($lineasProds)) {
        $resumenTexto .= "📦 *Productos Vendidos:*\n" . implode("\n", $lineasProds) . "\n";
    }

    // Control de Stock y Productos a Cuadrar
    $disc = $service->obtenerDiscrepanciasStockYProductos($cod, $arq['codarqueo'] ?? 0, $fechaIso);
    if ($disc['estado'] === 'DISCREPANCIAS_DETECTADAS') {
        $resumenTexto .= "🔍 *PRODUCTOS A CUADRAR / MERMAS:*\n";
        if (!empty($disc['faltantes'])) {
            $totalF = count($disc['faltantes']);
            $mostrados = array_slice($disc['faltantes'], 0, 5);
            foreach ($mostrados as $f) {
                $resumenTexto .= "   🔴 *FALTANTE:* " . trim($f['producto']) . " (" . number_format($f['diferencia'], 0) . " u.) - Costo: Bs. " . number_format($f['costo_total'], 2) . "\n";
            }
            if ($totalF > 5) {
                $resumenTexto .= "   _... y " . ($totalF - 5) . " mermas menores más (ver informe PDF)._\n";
            }
        }
        if (!empty($disc['sobrantes'])) {
            foreach (array_slice($disc['sobrantes'], 0, 2) as $s) {
                $resumenTexto .= "   🟡 *Sobrante:* " . trim($s['producto']) . " (+" . number_format($s['diferencia'], 0) . " u.)\n";
            }
        }
    } elseif ($disc['estado'] === 'CUADRADO_EXACTO') {
        $resumenTexto .= "📦 *Stock:* Cuadrado exacto (Sin faltantes ni mermas) ✅\n";
    } else {
        $resumenTexto .= "📦 *Stock:* ⏳ Sin conteo físico registrado en este turno\n";
    }

    // Alertas de auditoría operativa
    if (!empty($anomalias)) {
        foreach ($anomalias as $anom) {
            if (strpos($anom, 'Faltante de efectivo') !== false || strpos($anom, 'Sobrante de efectivo') !== false) continue;
            $resumenTexto .= "⚠️ *Nota:* {$anom}\n";
        }
    }

    $resumenTexto .= "────────────────────────────\n";
    $num++;

    // Generar ÚNICO PDF de Auditoría y Cuadre por sucursal
    $pdfCuadrePath = $dirSalida . "/{$slug}_auditoria_noche.pdf";
    $service->generarPdfCuadre($suc, 'Noche', $fechaHoy, $pdfCuadrePath);

    echo "✅ [{$nombre}] Generado informe de auditoría: " . basename($pdfCuadrePath) . "\n";

    // Preparar para cola de envíos (Solo 1 PDF ejecutivo por casa)
    $enviosQueue[] = [
        'pdfPath' => $pdfCuadrePath,
        'caption' => "📄 {$nombre} - Auditoría de Caja y Mermas Turno Noche ({$fechaHoy})"
    ];
}

$resumenTexto .= "\n📎 _Se adjunta 1 reporte oficial en PDF por sucursal (Auditoría de Caja y Mermas de Stock)._";

// 1. Encolar el Mensaje Resumen Ejecutivo
$datosMensaje = [
    'texto' => $resumenTexto,
    'creado' => date('Y-m-d H:i:s')
];
file_put_contents($colaLocal . '/envio_01_resumen_' . time() . '.json', json_encode($datosMensaje, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
echo "\n📤 Mensaje resumen consolidado encolado para WhatsApp.\n";

// 2. Encolar los 4 PDFs (1 por sucursal)
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
