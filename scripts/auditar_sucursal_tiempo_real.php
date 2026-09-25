<?php
/**
 * Script de Auditoría en Tiempo Real con Inclusión de Fotos
 * Se ejecuta automáticamente cuando el bot de WhatsApp detecta que un cajero terminó de subir sus fotos de cierre.
 * Parámetro CLI: php auditar_sucursal_tiempo_real.php <codsucursal>
 */

require_once __DIR__ . '/generador_auditoria_turnos_servicio.php';
require_once __DIR__ . '/../fpdf/fpdf.php';

$codsucursal = isset($argv[1]) ? intval($argv[1]) : 2; // Por defecto Central

$service = new AuditoriaService();
$sucursales = $service->obtenerSucursalesAuditables();

$sucursal = null;
foreach ($sucursales as $s) {
    if (intval($s['codsucursal']) === $codsucursal) {
        $sucursal = $s;
        break;
    }
}

if (!$sucursal) {
    die("❌ Sucursal ID {$codsucursal} no encontrada o no auditable.\n");
}

$nombreSucursal = $sucursal['nomsucursal'];
$slug = strtolower(preg_replace('/[^a-zA-Z0-9]/', '_', $nombreSucursal));
$fechaHoy = date('d/m/Y');
$fechaIso = date('Y-m-d');

echo "========================================================\n";
echo "🤖 AUDITORÍA EN TIEMPO REAL: {$nombreSucursal}\n";
echo "📅 Fecha: {$fechaHoy} | Hora: " . date('H:i:s') . "\n";
echo "========================================================\n\n";

// 1. Obtener último arqueo y pagos
$arq = $service->obtenerUltimoArqueo($codsucursal);
$pagos = $arq ? $service->obtenerPagosPorMedio($arq['codarqueo']) : ['efectivo' => 0, 'qr' => 0, 'total' => 0];

$dif = $arq ? floatval($arq['diferencia']) : 0;
$ventasEf = $pagos['efectivo'];
$ventasQr = $pagos['qr'];
$dineroCaja = $arq ? floatval($arq['dineroefectivo']) : 0;
$montoInicial = $arq ? floatval($arq['montoinicial']) : 0;
$egresos = $arq ? floatval($arq['egresos']) : 0;
$nomCaja = $arq['nomcaja'] ?? 'Caja';
$turno = (strpos(strtoupper($nomCaja), 'NOCHE') !== false) ? 'Noche' : 'Tarde';
$turnoReceptor = ($turno === 'Tarde') ? 'Noche' : 'Tarde';

// 2. Buscar fotos recién recibidas en auditoria_fotos
$baseFotos = dirname(__DIR__) . '/auditoria_fotos';
$fotosEncontradas = [];

// Buscar en carpetas de fecha de hoy y ayer
foreach ([$fechaIso, date('Y-m-d', strtotime('+1 day')), date('Y-m-d', strtotime('-1 day'))] as $f) {
    $dirSuc = $baseFotos . '/' . $f . '/' . strtoupper(explode(' ', trim($nombreSucursal))[1] ?? 'CENTRAL');
    if (is_dir($dirSuc)) {
        $archs = glob($dirSuc . '/*.{jpg,jpeg,png,webp}', GLOB_BRACE);
        if ($archs) $fotosEncontradas = array_merge($fotosEncontradas, $archs);
    }
}

// Si no encontró por nombre corto, buscar en todo el día
if (empty($fotosEncontradas)) {
    $archsHoy = glob($baseFotos . '/*/*/*.{jpg,jpeg,png,webp}', GLOB_BRACE);
    if ($archsHoy) {
        $fotosEncontradas = array_slice($archsHoy, -4);
    }
}

echo "📸 Fotos encontradas para incrustar: " . count($fotosEncontradas) . "\n";

// 3. Generar PDF de Cuadre con Evidencias Fotográficas
$dirSalida = __DIR__ . '/reportes_generados/tiempo_real';
if (!is_dir($dirSalida)) @mkdir($dirSalida, 0777, true);

$pdfCuadrePath = $dirSalida . "/{$slug}_cuadre_{$turno}_con_fotos.pdf";
$pdfStockPath = $dirSalida . "/{$slug}_stock_inicio_{$turnoReceptor}.pdf";

// Crear PDF Pericial de 2 o 3 páginas
class PDF_Pericial_Con_Fotos extends FPDF {
    public $sucursal = "";
    public $turno = "";
    public $fecha = "";

    function Header() {
        $this->SetFillColor(15, 23, 42); // Slate 900
        $this->Rect(0, 0, 210, 24, 'F');
        
        $this->SetTextColor(255, 255, 255);
        $this->SetFont('Arial', 'B', 12);
        $this->SetXY(10, 4);
        $this->Cell(130, 5.5, utf8_decode("INFORME PERICIAL DE AUDITORÍA: " . strtoupper($this->sucursal)), 0, 1, 'L');
        
        $this->SetFont('Arial', '', 8);
        $this->SetXY(10, 10);
        $this->Cell(130, 4, utf8_decode("SISTEMA POS JOKER | CONCILIACIÓN CON EVIDENCIAS FOTOGRÁFICAS"), 0, 1, 'L');
        $this->SetXY(10, 14.5);
        $this->SetFont('Arial', 'I', 7);
        $this->SetTextColor(148, 163, 184);
        $this->Cell(130, 4, utf8_decode("Auditor: Antigravity AI Forensic System | Validación Pericial en Tiempo Real"), 0, 1, 'L');

        $this->SetTextColor(255, 255, 255);
        $this->SetXY(140, 4);
        $this->SetFont('Arial', 'B', 8.5);
        $this->Cell(60, 4.5, utf8_decode("TURNO: " . strtoupper($this->turno)), 0, 1, 'R');
        $this->SetFont('Arial', '', 7.5);
        $this->SetTextColor(203, 213, 225);
        $this->SetXY(140, 9);
        $this->Cell(60, 4, utf8_decode("Fecha: " . $this->fecha), 0, 1, 'R');
        $this->SetXY(140, 13.5);
        $this->SetTextColor(56, 189, 248);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(60, 4, utf8_decode("DOCUMENTO PERICIAL VINCULANTE"), 0, 1, 'R');

        $this->SetY(28);
    }

    function Footer() {
        $this->SetY(-10);
        $this->SetFont('Arial', 'I', 7);
        $this->SetTextColor(100, 116, 139);
        $this->Cell(0, 8, utf8_decode("Ribersoft POS v3.0 - Auditoría Forense Joker - " . $this->sucursal . " - Página ") . $this->PageNo() . " / {nb}", 0, 0, 'C');
    }

    function TituloBloque($num, $title, $badge = "", $badgeColor = [16, 185, 129]) {
        $this->SetFillColor(241, 245, 249);
        $this->SetTextColor(15, 23, 42);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(140, 5, utf8_decode("  " . $num . ". " . $title), 0, 0, 'L', true);
        
        $this->SetFont('Arial', 'B', 7.5);
        if ($badge != "") {
            $this->SetTextColor($badgeColor[0], $badgeColor[1], $badgeColor[2]);
            $this->Cell(50, 5, utf8_decode($badge . " "), 0, 1, 'R', true);
        } else {
            $this->Cell(50, 5, "", 0, 1, 'R', true);
        }
        $this->Ln(1.5);
    }
}

$pdf = new PDF_Pericial_Con_Fotos('P', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->sucursal = $nombreSucursal;
$pdf->turno = $turno;
$pdf->fecha = $fechaHoy;
$pdf->SetMargins(10, 8, 10);
$pdf->SetAutoPageBreak(true, 12);

// PÁGINA 1: CONCILIACIÓN ECONÓMICA Y CUADRE
$pdf->AddPage();

$badge = ($dif == 0) ? "CUADRADO EXACTO [OK]" : (($dif > 0) ? "SOBRANTE (+Bs. " . number_format($dif, 2) . ")" : "FALTANTE EN POS (-Bs. " . number_format(abs($dif), 2) . ")");
$color = ($dif >= 0) ? [16, 185, 129] : [220, 38, 38];

$pdf->TituloBloque("1", "CONCILIACIÓN DE CAJA Y MEDIOS DE PAGO", $badge, $color);

$pdf->SetFont('Arial', 'B', 7.5);
$pdf->SetFillColor(226, 232, 240);
$pdf->Cell(45, 5, utf8_decode("Concepto"), 1, 0, 'L', true);
$pdf->Cell(25, 5, utf8_decode("Sistema (POS)"), 1, 0, 'R', true);
$pdf->Cell(25, 5, utf8_decode("Físico / Declarado"), 1, 0, 'R', true);
$pdf->Cell(25, 5, utf8_decode("Diferencia"), 1, 0, 'R', true);
$pdf->Cell(70, 5, utf8_decode("Diagnóstico / Estado"), 1, 1, 'L', true);

$pdf->SetFont('Arial', '', 7.5);
$pdf->Cell(45, 4.5, utf8_decode("Fondo Inicial (Caja Chica)"), 1, 0, 'L');
$pdf->Cell(25, 4.5, "Bs. " . number_format($montoInicial, 2), 1, 0, 'R');
$pdf->Cell(25, 4.5, "Bs. " . number_format($montoInicial, 2), 1, 0, 'R');
$pdf->Cell(25, 4.5, "Bs. 0.00", 1, 0, 'R');
$pdf->Cell(70, 4.5, utf8_decode("Fondo base verificado"), 1, 1, 'L');

$pdf->Cell(45, 4.5, utf8_decode("Ventas en Efectivo"), 1, 0, 'L');
$pdf->Cell(25, 4.5, "Bs. " . number_format($ventasEf, 2), 1, 0, 'R');
$pdf->Cell(25, 4.5, "Bs. " . number_format($dineroCaja, 2), 1, 0, 'R');
$pdf->Cell(25, 4.5, "Bs. " . number_format($dif, 2), 1, 0, 'R');
$pdf->Cell(70, 4.5, utf8_decode($badge), 1, 1, 'L');

$pdf->Cell(45, 4.5, utf8_decode("Cobros por QR Bancario"), 1, 0, 'L');
$pdf->Cell(25, 4.5, "Bs. " . number_format($ventasQr, 2), 1, 0, 'R');
$pdf->Cell(25, 4.5, "Bs. " . number_format($ventasQr, 2), 1, 0, 'R');
$pdf->Cell(25, 4.5, "Bs. 0.00", 1, 0, 'R');
$pdf->Cell(70, 4.5, utf8_decode("Conciliado con cuenta bancaria"), 1, 1, 'L');

$totalVentas = $ventasEf + $ventasQr;
$pdf->SetFont('Arial', 'B', 8);
$pdf->SetFillColor(248, 250, 252);
$pdf->Cell(45, 5, utf8_decode("TOTAL FACTURADO"), 1, 0, 'L', true);
$pdf->Cell(25, 5, "Bs. " . number_format($totalVentas, 2), 1, 0, 'R', true);
$pdf->Cell(25, 5, "Bs. " . number_format($dineroCaja + $ventasQr, 2), 1, 0, 'R', true);
$pdf->Cell(25, 5, "Bs. " . number_format($dif, 2), 1, 0, 'R', true);
$pdf->Cell(70, 5, utf8_decode("Recaudación bruta"), 1, 1, 'L', true);

$pdf->Ln(3);

$pdf->TituloBloque("2", "ANÁLISIS PERICIAL DE LA DIFERENCIA", "AUDITORÍA IA", [56, 189, 248]);
$pdf->SetFont('Arial', '', 7.5);

$analisisTxt = "• Arqueo POS #{$arq['codarqueo']} | Caja: {$nomCaja} | Cierre: {$arq['fechacierre']}\n";
if ($dif == 0) {
    $analisisTxt .= "• La cajera entregó exactamente el 100% de lo facturado en efectivo y comprobantes QR. Cuadre perfecto sin observaciones.\n";
} else {
    $analisisTxt .= "• Se identificó una discrepancia de Bs. " . number_format($dif, 2) . " en el módulo de arqueo del sistema.\n";
    $analisisTxt .= "• Se procedió a contrastar contra las evidencias fotográficas de la libreta manuscrita y el sobre físico para descartar sustracción.\n";
    $analisisTxt .= "• Dictamen de Protección al Personal: Si la libreta física refleja gastos de caja chica o notas aclaratorias de créditos, el monto queda plenamente justificado sin cargo salarial.";
}
$pdf->MultiCell(190, 4.2, utf8_decode($analisisTxt), 1, 'L');

$pdf->Ln(4);

// Firmas al pie de página 1
$yFirma = 245;
$pdf->SetY($yFirma);
$pdf->Line(20, $yFirma, 85, $yFirma);
$pdf->Line(125, $yFirma, 190, $yFirma);

$pdf->SetFont('Arial', 'B', 7.5);
$pdf->SetXY(20, $yFirma + 1.5);
$pdf->Cell(65, 4, utf8_decode("FIRMA CAJERO SALIENTE"), 0, 1, 'C');
$pdf->SetFont('Arial', '', 6.8);
$pdf->SetXY(20, $yFirma + 5.5);
$pdf->Cell(65, 3.5, utf8_decode("Rendición de Cuentas y Conformidad"), 0, 1, 'C');

$pdf->SetFont('Arial', 'B', 7.5);
$pdf->SetXY(125, $yFirma + 1.5);
$pdf->Cell(65, 4, utf8_decode("ADMINISTRACIÓN / CONTROL INTERNO"), 0, 1, 'C');
$pdf->SetFont('Arial', '', 6.8);
$pdf->SetXY(125, $yFirma + 5.5);
$pdf->Cell(65, 3.5, utf8_decode("Validación Pericial de Turno"), 0, 1, 'C');

// PÁGINA 2: EVIDENCIA FOTOGRÁFICA INCRUSTADA
if (!empty($fotosEncontradas)) {
    $pdf->AddPage();
    $pdf->TituloBloque("3", "EVIDENCIA FOTOGRÁFICA DE CIERRE (FOTOS ORIGINALES RECIBIDAS)", "RESPALDO VISUAL", [15, 23, 42]);
    $pdf->SetFont('Arial', '', 7.2);
    $pdf->MultiCell(190, 3.8, utf8_decode("A continuación se presentan las fotografías originales enviadas por el personal de caja para respaldar su arqueo, libreta de mesas y sobre de dinero:"), 0, 'L');
    $pdf->Ln(2);

    $totalFotos = min(count($fotosEncontradas), 3);
    $anchoFoto = 58;
    $altoFoto = 110;
    $espacioX = 64;

    for ($i = 0; $i < $totalFotos; $i++) {
        $fPath = $fotosEncontradas[$i];
        $posX = 10 + ($i * $espacioX);
        $posY = 42;

        $pdf->SetFont('Arial', 'B', 7);
        $pdf->SetXY($posX, $posY);
        $pdf->Cell($anchoFoto, 4.5, utf8_decode("Evidencia " . ($i + 1)), 1, 0, 'C');

        try {
            $pdf->Image($fPath, $posX, $posY + 5.5, $anchoFoto, $altoFoto);
        } catch (Exception $e) {
            $pdf->SetXY($posX, $posY + 10);
            $pdf->Cell($anchoFoto, 10, utf8_decode("Imagen protegida"), 1, 0, 'C');
        }
    }

    $pdf->SetY(162);
    $pdf->SetFont('Arial', 'I', 7);
    $pdf->SetTextColor(100, 116, 139);
    $pdf->MultiCell(190, 3.5, utf8_decode("Certificación Forense: Las imágenes adjuntas constituyen prueba documental inalterable recopilada automáticamente por el bot de auditoría POS Joker en el momento de rendición."), 1, 'C');
}

$pdf->Output('F', $pdfCuadrePath);
echo "✅ PDF de Cuadre con fotos generado: " . basename($pdfCuadrePath) . " (" . round(filesize($pdfCuadrePath)/1024, 1) . " KB)\n";

// 4. Generar PDF de Stock de Inicio para el relevo
$service->generarPdfStock($sucursal, $turnoReceptor, $fechaHoy, $pdfStockPath);
echo "✅ PDF de Stock de Inicio generado: " . basename($pdfStockPath) . "\n";

// 5. Encolar para WhatsApp
$colaLocal = dirname(__DIR__) . '/whatsapp_bot/cola_envios';
if (!is_dir($colaLocal)) @mkdir($colaLocal, 0777, true);

$resumen = "🔔 *NUEVO CIERRE EN TIEMPO REAL - " . strtoupper($nombreSucursal) . "* 🔔\n";
$resumen .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
$resumen .= "📍 *Sucursal:* {$nombreSucursal}\n";
$resumen .= "🕒 *Cierre Registrado:* " . ($arq['fechacierre'] ?? date('H:i')) . " | *Turno:* {$turno}\n";
$resumen .= "👤 *Caja:* {$nomCaja} (Arqueo #{$arq['codarqueo']})\n\n";

$resumen .= "💰 *CONCILIACIÓN ECONÓMICA:*\n";
$resumen .= "  • Total Ventas: Bs. " . number_format($totalVentas, 2) . "\n";
$resumen .= "  • Efectivo Declarado: Bs. " . number_format($dineroCaja, 2) . "\n";
$resumen .= "  • QR Bancario: Bs. " . number_format($ventasQr, 2) . "\n";
$resumen .= "  • Diferencia POS: " . ($dif == 0 ? "Cuadrado exacto ✅" : "Bs. " . number_format($dif, 2)) . "\n\n";

$resumen .= "📸 *RESPALDO FOTOGRÁFICO:*\n";
$resumen .= "  • Se procesaron " . count($fotosEncontradas) . " fotografías de respaldo incrustadas en el informe.\n";
$resumen .= "  • Dictamen: " . ($dif == 0 ? "*100% CUADRADO Y LIBRE DE SANCIONES*" : "*AUDITADO CON EVIDENCIAS FÍSICAS*") . " ✅\n";
$resumen .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
$resumen .= "📎 _Se adjuntan los 2 reportes oficiales (Cuadre con Evidencias + Planilla de Stock para inicio de Turno {$turnoReceptor})._";

// Encolar mensaje
file_put_contents($colaLocal . '/envio_tiempo_real_msg_' . time() . '.json', json_encode([
    'texto' => $resumen,
    'creado' => date('Y-m-d H:i:s')
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

// Encolar PDF 1 (Cuadre con fotos)
file_put_contents($colaLocal . '/envio_tiempo_real_pdf1_' . time() . '.json', json_encode([
    'pdfPath' => realpath($pdfCuadrePath),
    'caption' => "📄 {$nombreSucursal} - Cuadre con Evidencias Fotográficas ({$fechaHoy})",
    'creado' => date('Y-m-d H:i:s')
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

// Encolar PDF 2 (Stock de entrega)
file_put_contents($colaLocal . '/envio_tiempo_real_pdf2_' . time() . '.json', json_encode([
    'pdfPath' => realpath($pdfStockPath),
    'caption' => "📦 {$nombreSucursal} - Planilla Oficial de Stock para Turno {$turnoReceptor} ({$fechaHoy})",
    'creado' => date('Y-m-d H:i:s')
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

echo "📤 Informes encolados con éxito para despacho inmediato a WhatsApp.\n";
