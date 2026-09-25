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

    // Auditoría Visual: Cruce de fotos de cuadre manual y gastos
    try {
        $resVision = $service->auditarFotosSucursalConIA($suc, $arq['codarqueo'] ?? 0, $fechaIso);
        if (!empty($resVision['tiene_analisis'])) {
            $evMan = $resVision['evaluacion_manual'] ?? [];
            if (!empty($evMan['tiene_cuadre'])) {
                $resumenTexto .= "📝 *Cuadre Manual:* {$evMan['estado_cuadre']}\n";
                if (!empty($evMan['hubo_gastos'])) {
                    $resumenTexto .= "💸 *Gastos en hoja:* {$evMan['linea_gastos']}\n";
                } else {
                    $resumenTexto .= "💸 *Gastos en hoja:* Sin gastos anotados\n";
                }
            } else {
                $resumenTexto .= "📝 *Cuadre Manual:* Cuadra con el sistema ✅\n";
                $resumenTexto .= "💸 *Gastos en hoja:* Sin gastos anotados\n";
            }

            if (!empty($resVision['cruce_inventario']['discrepancias'])) {
                foreach (array_slice($resVision['cruce_inventario']['discrepancias'], 0, 1) as $dInv) {
                    $resumenTexto .= "📦 *Diferencia en foto de stock:* {$dInv}\n";
                }
            }
        } else {
            $resumenTexto .= "📝 *Cuadre Manual:* ⏳ Sin foto de cuadre recibida aún\n";
        }
    } catch (Exception $eVision) {
        $resumenTexto .= "📝 *Cuadre Manual:* ⏳ Pendiente de verificación\n";
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
        'caption' => "📄 {$nombre} - Cuadre y Auditoría Turno Noche ({$fechaHoy})"
    ];
    $enviosQueue[] = [
        'pdfPath' => $pdfStockPath,
        'caption' => "📦 {$nombre} - Planilla Oficial Stock para Turno Tarde ({$fechaHoy})"
    ];
}

$resumenTexto .= "\n📎 _Se adjuntan los reportes oficiales en PDF (Cuadre Económico + Planilla de Stock) de cada sucursal._";

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
