<?php
require_once __DIR__ . '/../fpdf/fpdf.php';

class PDF_Auditoria_Corta extends FPDF {
    function Header() {
        // Encabezado compacto
        $this->SetFillColor(30, 41, 59); // Slate oscuro
        $this->Rect(0, 0, 210, 22, 'F');
        
        $this->SetTextColor(255, 255, 255);
        $this->SetFont('Arial', 'B', 13);
        $this->SetXY(10, 4);
        $this->Cell(120, 6, utf8_decode("INFORME DE AUDITORÍA Y CONTROL DE CAJA"), 0, 1, 'L');
        
        $this->SetFont('Arial', '', 8.5);
        $this->SetXY(10, 10);
        $this->Cell(120, 5, utf8_decode("SISTEMA POS RIBERSOFT | SUCURSAL: JOKER ULTRA"), 0, 1, 'L');
        $this->SetXY(10, 15);
        $this->SetFont('Arial', 'I', 7.5);
        $this->Cell(120, 4, utf8_decode("Auditoría realizada por: Daniel Méndez Amutari"), 0, 1, 'L');

        $this->SetXY(135, 4);
        $this->SetFont('Arial', 'B', 8.5);
        $this->Cell(65, 5, utf8_decode("PERÍODO: 16/08/2026 - 12/09/2026"), 0, 1, 'R');
        $this->SetFont('Arial', '', 7.5);
        $this->SetXY(135, 9);
        $this->Cell(65, 4, utf8_decode("Cajas: ULTRATARDE / ULTRANOCHE"), 0, 1, 'R');
        $this->SetXY(135, 14);
        $this->Cell(65, 4, utf8_decode("Fecha Emisión: 12 de Septiembre, 2026"), 0, 1, 'R');

        $this->Ln(7);
    }

    function Footer() {
        $this->SetY(-10);
        $this->SetFont('Arial', 'I', 7);
        $this->SetTextColor(140, 140, 140);
        $this->Cell(0, 8, utf8_decode("Sistema POS Ribersoft - Auditoría de Sucursales - Daniel Méndez Amutari - Página 1 de 1"), 0, 0, 'C');
    }

    function TituloBloque($title) {
        $this->SetFillColor(241, 245, 249);
        $this->SetTextColor(15, 23, 42);
        $this->SetFont('Arial', 'B', 8.5);
        $this->Cell(0, 5.5, utf8_decode("  " . $title), 0, 1, 'L', true);
        $this->SetDrawColor(203, 213, 225);
        $this->Line(10, $this->GetY(), 200, $this->GetY());
        $this->Ln(1.5);
    }
}

$pdf = new PDF_Auditoria_Corta('P', 'mm', 'A4');
$pdf->SetMargins(10, 8, 10);
$pdf->SetAutoPageBreak(false); // Para asegurar exactamente 1 página
$pdf->AddPage();

// 1. RESUMEN GENERAL DE RECAUDACIÓN
$pdf->TituloBloque("1. RESUMEN GENERAL DE MOVIMIENTOS (52 TURNOS AUDITADOS)");

$pdf->SetFont('Arial', 'B', 7.5);
$pdf->SetFillColor(226, 232, 240);
$pdf->SetTextColor(30, 41, 59);
$pdf->Cell(48, 5, utf8_decode("Medio / Canal"), 1, 0, 'L', true);
$pdf->Cell(32, 5, utf8_decode("Transacciones"), 1, 0, 'C', true);
$pdf->Cell(55, 5, utf8_decode("Importe Recaudado"), 1, 0, 'R', true);
$pdf->Cell(55, 5, utf8_decode("Composición / Participación"), 1, 1, 'C', true);

$pdf->SetFont('Arial', '', 7.5);
$pdf->Cell(48, 4.5, utf8_decode("Ventas por QR"), 1, 0, 'L');
$pdf->Cell(32, 4.5, utf8_decode("148 ventas"), 1, 0, 'C');
$pdf->Cell(55, 4.5, utf8_decode("Bs. 44.923,00"), 1, 0, 'R');
$pdf->Cell(55, 4.5, utf8_decode("56,8 %"), 1, 1, 'C');

$pdf->Cell(48, 4.5, utf8_decode("Ventas en Efectivo"), 1, 0, 'L');
$pdf->Cell(32, 4.5, utf8_decode("165 ventas"), 1, 0, 'C');
$pdf->Cell(55, 4.5, utf8_decode("Bs. 34.128,00"), 1, 0, 'R');
$pdf->Cell(55, 4.5, utf8_decode("43,2 %"), 1, 1, 'C');

$pdf->SetFont('Arial', 'B', 7.5);
$pdf->SetFillColor(241, 245, 249);
$pdf->Cell(48, 4.8, utf8_decode("TOTAL RECAUDACIÓN"), 1, 0, 'L', true);
$pdf->Cell(32, 4.8, utf8_decode("313 ventas"), 1, 0, 'C', true);
$pdf->Cell(55, 4.8, utf8_decode("Bs. 79.051,00"), 1, 0, 'R', true);
$pdf->Cell(55, 4.8, utf8_decode("Productos: 73,3% | Mesas Billar: 26,7%"), 1, 1, 'C', true);
$pdf->Ln(2);

// 2. FALTANTES DE EFECTIVO INJUSTIFICADOS (A DESCONTAR)
$pdf->TituloBloque("2. FALTANTES DE EFECTIVO EN CAJA A DESCONTAR DIRECTO (SIN JUSTIFICAR)");

$pdf->SetFont('Arial', 'B', 7);
$pdf->SetFillColor(254, 226, 226);
$pdf->SetTextColor(153, 27, 27);
$pdf->Cell(18, 4.5, utf8_decode("N° Arqueo"), 1, 0, 'C', true);
$pdf->Cell(30, 4.5, utf8_decode("Caja / Turno"), 1, 0, 'C', true);
$pdf->Cell(32, 4.5, utf8_decode("Fecha y Hora"), 1, 0, 'C', true);
$pdf->Cell(30, 4.5, utf8_decode("Efectivo Sistema"), 1, 0, 'R', true);
$pdf->Cell(30, 4.5, utf8_decode("Físico Entregado"), 1, 0, 'R', true);
$pdf->Cell(25, 4.5, utf8_decode("Faltante"), 1, 0, 'R', true);
$pdf->Cell(25, 4.5, utf8_decode("Observación"), 1, 1, 'C', true);

$pdf->SetFont('Arial', '', 7);
$pdf->SetTextColor(30, 41, 59);
$pdf->Cell(18, 4.3, utf8_decode("#74"), 1, 0, 'C');
$pdf->Cell(30, 4.3, utf8_decode("ULTRATARDE"), 1, 0, 'C');
$pdf->Cell(32, 4.3, utf8_decode("24/08/2026 02:27"), 1, 0, 'C');
$pdf->Cell(30, 4.3, utf8_decode("Bs. 181,00"), 1, 0, 'R');
$pdf->Cell(30, 4.3, utf8_decode("Bs. 41,00"), 1, 0, 'R');
$pdf->SetFont('Arial', 'B', 7);
$pdf->SetTextColor(185, 28, 28);
$pdf->Cell(25, 4.3, utf8_decode("-Bs. 140,00"), 1, 0, 'R');
$pdf->SetFont('Arial', '', 6.5);
$pdf->Cell(25, 4.3, utf8_decode("Sin justificar"), 1, 1, 'C');

$pdf->SetFont('Arial', '', 7);
$pdf->SetTextColor(30, 41, 59);
$pdf->Cell(18, 4.3, utf8_decode("#214"), 1, 0, 'C');
$pdf->Cell(30, 4.3, utf8_decode("ULTRANOCHE"), 1, 0, 'C');
$pdf->Cell(32, 4.3, utf8_decode("11/09/2026 03:21"), 1, 0, 'C');
$pdf->Cell(30, 4.3, utf8_decode("Bs. 603,00"), 1, 0, 'R');
$pdf->Cell(30, 4.3, utf8_decode("Bs. 583,00"), 1, 0, 'R');
$pdf->SetFont('Arial', 'B', 7);
$pdf->SetTextColor(185, 28, 28);
$pdf->Cell(25, 4.3, utf8_decode("-Bs. 20,00"), 1, 0, 'R');
$pdf->SetFont('Arial', '', 6.5);
$pdf->Cell(25, 4.3, utf8_decode("Sin justificar"), 1, 1, 'C');

$pdf->SetFont('Arial', 'B', 7);
$pdf->SetFillColor(254, 242, 242);
$pdf->Cell(140, 4.5, utf8_decode("SUBTOTAL FALTANTE NETO DE EFECTIVO (A DESCONTAR)"), 1, 0, 'R', true);
$pdf->Cell(25, 4.5, utf8_decode("-Bs. 160,00"), 1, 0, 'R', true);
$pdf->Cell(25, 4.5, utf8_decode("Retención obligatoria"), 1, 1, 'C', true);
$pdf->Ln(2);

// 3. FALTANTES DE MERCANCÍA (RELEVOS CIEGOS)
$pdf->TituloBloque("3. PÉRDIDAS FÍSICAS EN INVENTARIO (RELEVOS CIEGOS COMPROBADOS)");

$pdf->SetFont('Arial', 'B', 7);
$pdf->SetFillColor(254, 226, 226);
$pdf->SetTextColor(153, 27, 27);
$pdf->Cell(45, 4.5, utf8_decode("Producto"), 1, 0, 'L', true);
$pdf->Cell(22, 4.5, utf8_decode("Faltante Físico"), 1, 0, 'C', true);
$pdf->Cell(25, 4.5, utf8_decode("Costo Unit."), 1, 0, 'R', true);
$pdf->Cell(33, 4.5, utf8_decode("Pérdida al Costo"), 1, 0, 'R', true);
$pdf->Cell(35, 4.5, utf8_decode("Pérdida a Precio Venta"), 1, 0, 'R', true);
$pdf->Cell(30, 4.5, utf8_decode("Comportamiento"), 1, 1, 'C', true);

$pdf->SetFont('Arial', '', 7);
$pdf->SetTextColor(30, 41, 59);
$pdf->Cell(45, 4.2, utf8_decode("COCA KOLLITA"), 1, 0, 'L');
$pdf->Cell(22, 4.2, utf8_decode("-3 unidades"), 1, 0, 'C');
$pdf->Cell(25, 4.2, utf8_decode("Bs. 17,00"), 1, 0, 'R');
$pdf->Cell(33, 4.2, utf8_decode("Bs. 51,00"), 1, 0, 'R');
$pdf->Cell(35, 4.2, utf8_decode("Bs. 90,00"), 1, 0, 'R');
$pdf->Cell(30, 4.2, utf8_decode("Crónico (03 al 11/09)"), 1, 1, 'C');

$pdf->Cell(45, 4.2, utf8_decode("GUANTES BILLAR"), 1, 0, 'L');
$pdf->Cell(22, 4.2, utf8_decode("-3 pares"), 1, 0, 'C');
$pdf->Cell(25, 4.2, utf8_decode("Bs. 0,00"), 1, 0, 'R');
$pdf->Cell(33, 4.2, utf8_decode("Bs. 0,00"), 1, 0, 'R');
$pdf->Cell(35, 4.2, utf8_decode("Bs. 6,00"), 1, 0, 'R');
$pdf->Cell(30, 4.2, utf8_decode("Crónico (07 al 11/09)"), 1, 1, 'C');

$pdf->Cell(45, 4.2, utf8_decode("PACEÑA / BURGUESA"), 1, 0, 'L');
$pdf->Cell(22, 4.2, utf8_decode("-1 c/u (-2 uds)"), 1, 0, 'C');
$pdf->Cell(25, 4.2, utf8_decode("Var."), 1, 0, 'R');
$pdf->Cell(33, 4.2, utf8_decode("Bs. 26,37"), 1, 0, 'R');
$pdf->Cell(35, 4.2, utf8_decode("Bs. 52,00"), 1, 0, 'R');
$pdf->Cell(30, 4.2, utf8_decode("Faltante relevo 11/09"), 1, 1, 'C');

$pdf->SetFont('Arial', 'B', 7);
$pdf->SetFillColor(254, 242, 242);
$pdf->Cell(92, 4.5, utf8_decode("TOTAL PÉRDIDAS FÍSICAS EN RELEVOS"), 1, 0, 'L', true);
$pdf->Cell(33, 4.5, utf8_decode("Bs. 77,37 (Costo)"), 1, 0, 'R', true);
$pdf->Cell(35, 4.5, utf8_decode("Bs. 148,00 (Venta)"), 1, 0, 'R', true);
$pdf->Cell(30, 4.5, utf8_decode("A deducir"), 1, 1, 'C', true);

$pdf->SetFont('Arial', 'I', 6.8);
$pdf->SetTextColor(100, 116, 139);
$pdf->Cell(0, 4, utf8_decode("* Aclaración: Las 120 Coronas del 08/09 correspondían a la Compra #60 recibida; cuadraron al 100% al día siguiente."), 0, 1, 'L');
$pdf->Ln(1);

// 4. SALIDAS DE CAJA PARA PAGOS A PERSONAL (A CRUZAR CON PLANILLA)
$pdf->TituloBloque("4. SALIDAS DE EFECTIVO TOMADAS DE CAJA (CRUZAR CON PLANILLAS DE SUELDOS)");

$pdf->SetFont('Arial', '', 7);
$pdf->SetTextColor(30, 41, 59);
$pdf->Cell(45, 4.2, utf8_decode("Arqueo #15 (17/08/2026)"), 1, 0, 'L');
$pdf->Cell(25, 4.2, utf8_decode("Bs. 300,00"), 1, 0, 'R');
$pdf->Cell(120, 4.2, utf8_decode("\"SE PAGO PERSONAL 300BS\" - Verificar con recibo de personal"), 1, 1, 'L');

$pdf->Cell(45, 4.2, utf8_decode("Arqueo #33 (18/08/2026)"), 1, 0, 'L');
$pdf->Cell(25, 4.2, utf8_decode("Bs. 120,00"), 1, 0, 'R');
$pdf->Cell(120, 4.2, utf8_decode("\"SE CANCELO 120 REENPLAZO DE YESSICA MESERA\" - Descontar de nómina de mesera"), 1, 1, 'L');

$pdf->Cell(45, 4.2, utf8_decode("Arqueo #178 (07/09/2026)"), 1, 0, 'L');
$pdf->Cell(25, 4.2, utf8_decode("Bs. 300,00"), 1, 0, 'R');
$pdf->Cell(120, 4.2, utf8_decode("\"SEN PAGO PERSONAL DOMINGO 300 BS\" - Verificar con personal de domingo"), 1, 1, 'L');

$pdf->SetFont('Arial', 'B', 7);
$pdf->SetFillColor(241, 245, 249);
$pdf->Cell(45, 4.5, utf8_decode("SUBTOTAL SALIDAS"), 1, 0, 'L', true);
$pdf->Cell(25, 4.5, utf8_decode("Bs. 720,00"), 1, 0, 'R', true);
$pdf->Cell(120, 4.5, utf8_decode("YA EXTRAÍDOS DE CAJA: No pagar de nuevo en planilla mensual"), 1, 1, 'L', true);
$pdf->Ln(2);

// 5. RESUMEN DE LIQUIDACIÓN Y DICTAMEN DE PAGO MENSUAL
$pdf->TituloBloque("5. DICTAMEN FINAL Y LIQUIDACIÓN PARA EL PAGO DEL MES");

$pdf->SetFont('Arial', 'B', 8);
$pdf->SetFillColor(30, 41, 59);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(145, 5.5, utf8_decode("CONCEPTO DE DEDUCCIÓN O VERIFICACIÓN"), 1, 0, 'L', true);
$pdf->Cell(45, 5.5, utf8_decode("MONTO FINAL"), 1, 1, 'R', true);

$pdf->SetFont('Arial', '', 7.5);
$pdf->SetTextColor(30, 41, 59);
$pdf->Cell(145, 4.8, utf8_decode("1. Faltantes Líquidos Injustificados de Caja (Arqueos #74 y #214)"), 1, 0, 'L');
$pdf->SetFont('Arial', 'B', 7.5);
$pdf->SetTextColor(185, 28, 28);
$pdf->Cell(45, 4.8, utf8_decode("-Bs. 160,00"), 1, 1, 'R');

$pdf->SetFont('Arial', '', 7.5);
$pdf->SetTextColor(30, 41, 59);
$pdf->Cell(145, 4.8, utf8_decode("2. Pérdidas Físicas en Mercancía (Coca Kollita, Guantes, Paceña, Burguesa al costo)"), 1, 0, 'L');
$pdf->SetFont('Arial', 'B', 7.5);
$pdf->SetTextColor(185, 28, 28);
$pdf->Cell(45, 4.8, utf8_decode("-Bs. 77,37"), 1, 1, 'R');

$pdf->SetFont('Arial', 'B', 8);
$pdf->SetFillColor(254, 226, 226);
$pdf->SetTextColor(153, 27, 27);
$pdf->Cell(145, 5.5, utf8_decode("TOTAL RETENCIÓN / DEDUCCIÓN DIRECTA DEL PAGO MENSUAL"), 1, 0, 'L', true);
$pdf->Cell(45, 5.5, utf8_decode("-Bs. 237,37"), 1, 1, 'R', true);

$pdf->SetFont('Arial', 'I', 7);
$pdf->SetTextColor(100, 116, 139);
$pdf->Cell(0, 4.2, utf8_decode("(Nota: Si la mercancía faltante se descuenta a precio de venta al público, el total a descontar asciende a -Bs. 308,00)."), 0, 1, 'L');
$pdf->Ln(2);

// Anomalías breves
$pdf->SetFont('Arial', 'B', 7);
$pdf->SetTextColor(15, 23, 42);
$pdf->Cell(0, 4, utf8_decode("OBSERVACIONES OPERATIVAS DE CONTROL INTERNO:"), 0, 1, 'L');
$pdf->SetFont('Arial', '', 6.8);
$pdf->SetTextColor(51, 65, 85);
$pdf->MultiCell(0, 3.4, utf8_decode("• Carga en bloque al cierre: 26 turnos abrieron el POS menos de 45 minutos antes de retirarse, cargando ventas acumuladas en papel. Se debe ordenar el registro en tiempo real.\n• Módulo de Egresos: 0 egresos registrados en sistema; las salidas de efectivo deben registrarse formalmente con comprobante."), 0, 'J');
$pdf->Ln(6);

// Firmas
$yFirma = $pdf->GetY();
$pdf->SetDrawColor(100, 116, 139);
$pdf->Line(25, $yFirma + 7, 85, $yFirma + 7);
$pdf->Line(125, $yFirma + 7, 185, $yFirma + 7);

$pdf->SetFont('Arial', 'B', 7.5);
$pdf->SetTextColor(15, 23, 42);
$pdf->SetXY(25, $yFirma + 8);
$pdf->Cell(60, 4, utf8_decode("Daniel Méndez Amutari"), 0, 0, 'C');
$pdf->SetXY(125, $yFirma + 8);
$pdf->Cell(60, 4, utf8_decode("Responsable / Cajero(a)"), 0, 1, 'C');

$pdf->SetFont('Arial', '', 6.8);
$pdf->SetTextColor(100, 116, 139);
$pdf->SetXY(25, $yFirma + 12);
$pdf->Cell(60, 3.5, utf8_decode("Auditor General - Sistema Ribersoft"), 0, 0, 'C');
$pdf->SetXY(125, $yFirma + 12);
$pdf->Cell(60, 3.5, utf8_decode("Sucursal Joker Ultra - Firma y C.I."), 0, 1, 'C');

// Guardar en la carpeta solicitada
$destFolder = "C:/Users/mende/OneDrive/Documentos/billar joker doc";
if (!file_exists($destFolder)) {
    mkdir($destFolder, 0777, true);
}
$destPath = $destFolder . "/Informe_Auditoria_Joker_Ultra.pdf";
$localPath = __DIR__ . "/../informe_auditoria_sucursal_ultra.pdf";

$pdf->Output('F', $destPath);
$pdf->Output('F', $localPath);

echo "PDF compacto de 1 página generado exitosamente en:\n";
echo "1) $destPath\n";
echo "2) $localPath\n";
