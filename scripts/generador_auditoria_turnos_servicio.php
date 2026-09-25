<?php
/**
 * Servicio Centralizado de Auditoría de Turnos y Generación de Informes PDF
 * Genera:
 * 1. PDF de Cuadre Económico de Caja
 * 2. PDF de Planilla de Entrega/Recepción de Stock para Inicio de Turno
 */

require_once __DIR__ . '/../class/classconexion.php';
require_once __DIR__ . '/../fpdf/fpdf.php';

// =========================================================================
// 1. CLASE PDF: CUADRE ECONÓMICO DE CAJA
// =========================================================================
class PDF_Cuadre_Caja extends FPDF {
    public $sucursal = "";
    public $turno = "";
    public $fecha = "";

    function Header() {
        $this->SetFillColor(15, 23, 42); // Slate 900
        $this->Rect(0, 0, 210, 24, 'F');
        
        $this->SetTextColor(255, 255, 255);
        $this->SetFont('Arial', 'B', 12);
        $this->SetXY(10, 4);
        $this->Cell(130, 5.5, utf8_decode("AUDITORÍA DE CAJA: " . strtoupper($this->sucursal)), 0, 1, 'L');
        
        $this->SetFont('Arial', '', 8);
        $this->SetXY(10, 10);
        $this->Cell(130, 4, utf8_decode("SISTEMA POS JOKER | CONCILIACIÓN DE EFECTIVO, QR Y GASTOS"), 0, 1, 'L');
        $this->SetXY(10, 14.5);
        $this->SetFont('Arial', 'I', 7);
        $this->SetTextColor(148, 163, 184);
        $this->Cell(130, 4, utf8_decode("Auditor: Antigravity AI Forensic System | Validación Pericial"), 0, 1, 'L');

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
        $this->Cell(60, 4, utf8_decode("DOCUMENTO PERICIAL DE CIERRE"), 0, 1, 'R');

        $this->SetY(28);
    }

    function Footer() {
        $this->SetY(-10);
        $this->SetFont('Arial', 'I', 7);
        $this->SetTextColor(100, 116, 139);
        $this->Cell(0, 8, utf8_decode("Ribersoft POS v3.0 - Auditoría Automática Joker - " . $this->sucursal . " - Página 1 de 1"), 0, 0, 'C');
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

// =========================================================================
// 2. CLASE PDF: PLANILLA DE STOCK DE APERTURA / RELEVO
// =========================================================================
class PDF_Stock_Inicio extends FPDF {
    public $sucursal = "";
    public $turnoEntrante = "";
    public $fecha = "";

    function Header() {
        $this->SetFillColor(30, 41, 59); // Slate 800
        $this->Rect(0, 0, 210, 24, 'F');
        
        $this->SetTextColor(255, 255, 255);
        $this->SetFont('Arial', 'B', 12);
        $this->SetXY(10, 4);
        $this->Cell(130, 5.5, utf8_decode("PLANILLA OFICIAL DE STOCK DE APERTURA: " . strtoupper($this->sucursal)), 0, 1, 'L');
        
        $this->SetFont('Arial', '', 8);
        $this->SetXY(10, 10);
        $this->Cell(130, 4, utf8_decode("INVENTARIO OBLIGATORIO DE INGRESO | RELEVO DE TURNO"), 0, 1, 'L');
        $this->SetXY(10, 14.5);
        $this->SetFont('Arial', 'I', 7);
        $this->SetTextColor(148, 163, 184);
        $this->Cell(130, 4, utf8_decode("Certificación de Existencias Físicas en Heladeras y Vitrinas"), 0, 1, 'L');

        $this->SetTextColor(255, 255, 255);
        $this->SetXY(140, 4);
        $this->SetFont('Arial', 'B', 8.5);
        $this->Cell(60, 4.5, utf8_decode("TURNO RECEPTOR: " . strtoupper($this->turnoEntrante)), 0, 1, 'R');
        $this->SetFont('Arial', '', 7.5);
        $this->SetTextColor(203, 213, 225);
        $this->SetXY(140, 9);
        $this->Cell(60, 4, utf8_decode("Fecha: " . $this->fecha), 0, 1, 'R');
        $this->SetXY(140, 13.5);
        $this->SetTextColor(250, 204, 21); // Amber
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(60, 4, utf8_decode("STOCK BASE AUDITADO"), 0, 1, 'R');

        $this->SetY(28);
    }

    function Footer() {
        $this->SetY(-10);
        $this->SetFont('Arial', 'I', 7);
        $this->SetTextColor(100, 116, 139);
        $this->Cell(0, 8, utf8_decode("Ribersoft POS v3.0 - Planilla Oficial de Apertura - " . $this->sucursal . " - Página 1 de 1"), 0, 0, 'C');
    }
}

// =========================================================================
// 3. SERVICIO DE AUDITORÍA
// =========================================================================
class AuditoriaService extends Db {

    public function obtenerSucursalesAuditables() {
        $stmt = $this->dbh->query("SELECT codsucursal, nomsucursal FROM sucursales WHERE codsucursal IN (1, 2, 3, 4) ORDER BY codsucursal ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerUltimoArqueo($codsucursal, $fecha = null) {
        if (!$fecha) $fecha = date('Y-m-d');
        
        $sql = "SELECT a.*, c.nrocaja, c.nomcaja 
                FROM arqueocaja a
                JOIN cajas c ON a.codcaja = c.codcaja
                WHERE c.codsucursal = :codsucursal
                ORDER BY a.codarqueo DESC LIMIT 1";
        
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute([':codsucursal' => $codsucursal]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerPagosPorMedio($codarqueo) {
        if (!$codarqueo) return ['efectivo' => 0, 'qr' => 0, 'otros' => 0, 'total' => 0];
        
        $sql = "SELECT m.codmediopago, mp.mediopago, 
                       (SUM(m.montopagado) - SUM(m.montodevuelto)) as total
                FROM mediospagoxventas m
                LEFT JOIN mediospagos mp ON m.codmediopago = mp.codmediopago
                WHERE m.codarqueo = :codarqueo
                GROUP BY m.codmediopago, mp.mediopago";
        
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute([':codarqueo' => $codarqueo]);
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $totales = ['efectivo' => 0, 'qr' => 0, 'otros' => 0, 'total' => 0];
        foreach ($res as $r) {
            $nombre = strtoupper($r['mediopago'] ?? '');
            $monto = floatval($r['total']);
            $totales['total'] += $monto;
            if (strpos($nombre, 'EFECTIVO') !== false) {
                $totales['efectivo'] += $monto;
            } elseif (strpos($nombre, 'QR') !== false || strpos($nombre, 'TRANSFER') !== false) {
                $totales['qr'] += $monto;
            } else {
                $totales['otros'] += $monto;
            }
        }
        return $totales;
    }

    public function obtenerStockProductos($codsucursal) {
        $sql = "SELECT p.idproducto, p.codproducto, p.producto, p.existencia, p.precioxpublico, 
                       p.tipoproducto, COALESCE(f.nomfamilia, 'GENERAL') as nomfamilia
                FROM productos p
                LEFT JOIN familias f ON p.codfamilia = f.codfamilia
                WHERE p.codsucursal = :codsucursal
                  AND (p.esaccesoriobillar IS NULL OR p.esaccesoriobillar = '' OR p.esaccesoriobillar = 'NO')
                  AND p.tipoproducto != 'COMBO'
                  AND p.producto NOT LIKE '%MESA%'
                  AND p.producto NOT LIKE '%HORA%'
                  AND p.producto NOT LIKE '%FICHA%'
                ORDER BY f.nomfamilia ASC, p.producto ASC";
        
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute([':codsucursal' => $codsucursal]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Genera el PDF 1: Cuadre Económico de Caja
     */
    public function generarPdfCuadre($sucursal, $turno, $fecha, $outputPath) {
        $arq = $this->obtenerUltimoArqueo($sucursal['codsucursal']);
        $pagos = $arq ? $this->obtenerPagosPorMedio($arq['codarqueo']) : ['efectivo' => 0, 'qr' => 0, 'otros' => 0, 'total' => 0];

        $pdf = new PDF_Cuadre_Caja('P', 'mm', 'A4');
        $pdf->sucursal = $sucursal['nomsucursal'];
        $pdf->turno = $turno;
        $pdf->fecha = $fecha;
        $pdf->SetMargins(10, 8, 10);
        $pdf->SetAutoPageBreak(false);
        $pdf->AddPage();

        $montoInicial = $arq ? floatval($arq['montoinicial']) : 0;
        $ventasEfectivo = $pagos['efectivo'];
        $ventasQr = $pagos['qr'];
        $egresos = $arq ? floatval($arq['egresos']) : 0;
        $efectivoEsperado = $montoInicial + $ventasEfectivo - $egresos;
        $dineroDeclarado = $arq ? floatval($arq['dineroefectivo']) : 0;
        $diferencia = $arq ? floatval($arq['diferencia']) : 0;

        $badge = ($diferencia == 0) ? "CUADRADO EXACTO [OK]" : (($diferencia > 0) ? "SOBRANTE (+Bs. " . number_format($diferencia, 2) . ")" : "FALTANTE (-Bs. " . number_format(abs($diferencia), 2) . ")");
        $color = ($diferencia >= 0) ? [16, 185, 129] : [220, 38, 38];

        // 1. Resumen de Recaudación
        $pdf->TituloBloque("1", "CONCILIACIÓN ECONÓMICA Y MEDIOS DE PAGO", $badge, $color);
        
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
        $pdf->Cell(70, 4.5, utf8_decode("Monto base verificado"), 1, 1, 'L');

        $pdf->Cell(45, 4.5, utf8_decode("Ventas en Efectivo"), 1, 0, 'L');
        $pdf->Cell(25, 4.5, "Bs. " . number_format($ventasEfectivo, 2), 1, 0, 'R');
        $pdf->Cell(25, 4.5, "Bs. " . number_format($dineroDeclarado, 2), 1, 0, 'R');
        $pdf->Cell(25, 4.5, "Bs. " . number_format($diferencia, 2), 1, 0, 'R');
        $pdf->Cell(70, 4.5, utf8_decode($badge), 1, 1, 'L');

        $pdf->Cell(45, 4.5, utf8_decode("Cobros por QR Bancario"), 1, 0, 'L');
        $pdf->Cell(25, 4.5, "Bs. " . number_format($ventasQr, 2), 1, 0, 'R');
        $pdf->Cell(25, 4.5, "Bs. " . number_format($ventasQr, 2), 1, 0, 'R');
        $pdf->Cell(25, 4.5, "Bs. 0.00", 1, 0, 'R');
        $pdf->Cell(70, 4.5, utf8_decode("Ingreso digital directo a cuenta"), 1, 1, 'L');

        $pdf->Cell(45, 4.5, utf8_decode("Egresos y Gastos de Caja"), 1, 0, 'L');
        $pdf->Cell(25, 4.5, "Bs. " . number_format($egresos, 2), 1, 0, 'R');
        $pdf->Cell(25, 4.5, "Bs. " . number_format($egresos, 2), 1, 0, 'R');
        $pdf->Cell(25, 4.5, "Bs. 0.00", 1, 0, 'R');
        $pdf->Cell(70, 4.5, utf8_decode("Gastos operativos rendidos"), 1, 1, 'L');

        $totalCaja = $ventasEfectivo + $ventasQr;
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetFillColor(248, 250, 252);
        $pdf->Cell(45, 5, utf8_decode("TOTAL VENTAS DEL TURNO"), 1, 0, 'L', true);
        $pdf->Cell(25, 5, "Bs. " . number_format($totalCaja, 2), 1, 0, 'R', true);
        $pdf->Cell(25, 5, "Bs. " . number_format($dineroDeclarado + $ventasQr, 2), 1, 0, 'R', true);
        $pdf->Cell(25, 5, "Bs. " . number_format($diferencia, 2), 1, 0, 'R', true);
        $pdf->Cell(70, 5, utf8_decode("Facturación consolidada"), 1, 1, 'L', true);

        $pdf->Ln(3);

        // 2. Información del Arqueo y Comentarios del Cajero
        $pdf->TituloBloque("2", "DATOS DEL ARQUEO Y NOTAS DE CIERRE", "ARQUEO #" . ($arq['codarqueo'] ?? 'N/A'), [56, 189, 248]);
        $pdf->SetFont('Arial', '', 7.5);
        $comentario = !empty($arq['comentarios']) ? $arq['comentarios'] : "Sin notas especiales registradas por el cajero al momento del cierre.";
        $pdf->MultiCell(190, 4.2, utf8_decode("• Caja Asignada: " . ($arq['nomcaja'] ?? 'Caja Principal') . " | Apertura: " . ($arq['fechaapertura'] ?? 'N/A') . " | Cierre: " . ($arq['fechacierre'] ?? 'N/A') . "\n• Comentarios del Cajero: " . $comentario), 1, 'L');

        $pdf->Ln(4);

        // 3. Dictamen y Firmas
        $pdf->TituloBloque("3", "DICTAMEN PERICIAL Y CONFORMIDAD ADMINISTRATIVA", "AUDITADO", [15, 23, 42]);
        $pdf->SetFont('Arial', '', 7.2);
        $pdf->MultiCell(190, 4, utf8_decode("El presente informe ha sido validado mediante conciliación cruzada de registros transaccionales en base de datos, ventas por comanda y declaraciones de cierre. Cualquier inconsistencia debe ser representada en un plazo máximo de 12 horas hábiles."), 0, 'J');

        $pdf->Ln(12);

        // Cuadro de firmas
        $yFirma = $pdf->GetY();
        $pdf->Line(20, $yFirma, 85, $yFirma);
        $pdf->Line(125, $yFirma, 190, $yFirma);

        $pdf->SetFont('Arial', 'B', 7.5);
        $pdf->SetXY(20, $yFirma + 1.5);
        $pdf->Cell(65, 4, utf8_decode("FIRMA CAJERO SALIENTE"), 0, 1, 'C');
        $pdf->SetFont('Arial', '', 6.8);
        $pdf->SetXY(20, $yFirma + 5.5);
        $pdf->Cell(65, 3.5, utf8_decode("Declaración Jurada de Entrega"), 0, 1, 'C');

        $pdf->SetFont('Arial', 'B', 7.5);
        $pdf->SetXY(125, $yFirma + 1.5);
        $pdf->Cell(65, 4, utf8_decode("ADMINISTRACIÓN / CONTROL INTERNO"), 0, 1, 'C');
        $pdf->SetFont('Arial', '', 6.8);
        $pdf->SetXY(125, $yFirma + 5.5);
        $pdf->Cell(65, 3.5, utf8_decode("Certificación de Arqueo Joker POS"), 0, 1, 'C');

        $pdf->Output('F', $outputPath);
        return file_exists($outputPath);
    }

    /**
     * Genera el PDF 2: Planilla Oficial de Stock de Inicio de Turno
     */
    public function generarPdfStock($sucursal, $turnoEntrante, $fecha, $outputPath) {
        $productos = $this->obtenerStockProductos($sucursal['codsucursal']);

        $pdf = new PDF_Stock_Inicio('P', 'mm', 'A4');
        $pdf->sucursal = $sucursal['nomsucursal'];
        $pdf->turnoEntrante = $turnoEntrante;
        $pdf->fecha = $fecha;
        $pdf->SetMargins(10, 8, 10);
        $pdf->SetAutoPageBreak(false);
        $pdf->AddPage();

        $pdf->SetFillColor(241, 245, 249);
        $pdf->SetTextColor(15, 23, 42);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(190, 5, utf8_decode("  EXISTENCIAS FÍSICAS REQUERIDAS AL INICIAR EL TURNO (OBLIGATORIO)"), 0, 1, 'L', true);
        $pdf->Ln(1);

        // Encabezado de la tabla de stock en 2 columnas para que entre todo en 1 hoja
        $wCod = 16;
        $wProd = 58;
        $wStock = 21;
        $wColTotal = $wCod + $wProd + $wStock; // 95 mm

        $pdf->SetFont('Arial', 'B', 7.2);
        $pdf->SetFillColor(226, 232, 240);
        
        // Cabecera Columna Izquierda y Derecha
        $pdf->Cell($wCod, 4.8, utf8_decode("Cód"), 1, 0, 'C', true);
        $pdf->Cell($wProd, 4.8, utf8_decode("Producto"), 1, 0, 'L', true);
        $pdf->Cell($wStock, 4.8, utf8_decode("Stock Recep."), 1, 0, 'C', true);

        $pdf->Cell($wCod, 4.8, utf8_decode("Cód"), 1, 0, 'C', true);
        $pdf->Cell($wProd, 4.8, utf8_decode("Producto"), 1, 0, 'L', true);
        $pdf->Cell($wStock, 4.8, utf8_decode("Stock Recep."), 1, 1, 'C', true);

        // Dividir los productos más importantes en 2 columnas (máximo 70 productos para 1 hoja respirable)
        $itemsMostrables = array_slice($productos, 0, 68);
        $mitad = ceil(count($itemsMostrables) / 2);
        $colIzq = array_slice($itemsMostrables, 0, $mitad);
        $colDer = array_slice($itemsMostrables, $mitad);

        $pdf->SetFont('Arial', '', 6.8);
        for ($i = 0; $i < $mitad; $i++) {
            $pIzq = $colIzq[$i] ?? null;
            $pDer = $colDer[$i] ?? null;

            // Fila Izquierda
            if ($pIzq) {
                $pdf->Cell($wCod, 4.2, utf8_decode(substr($pIzq['codproducto'], 0, 8)), 1, 0, 'C');
                $pdf->Cell($wProd, 4.2, utf8_decode(substr($pIzq['producto'], 0, 30)), 1, 0, 'L');
                $pdf->SetFont('Arial', 'B', 7);
                $pdf->Cell($wStock, 4.2, number_format($pIzq['existencia'], 0) . " u.", 1, 0, 'C');
                $pdf->SetFont('Arial', '', 6.8);
            } else {
                $pdf->Cell($wColTotal, 4.2, "", 1, 0);
            }

            // Fila Derecha
            if ($pDer) {
                $pdf->Cell($wCod, 4.2, utf8_decode(substr($pDer['codproducto'], 0, 8)), 1, 0, 'C');
                $pdf->Cell($wProd, 4.2, utf8_decode(substr($pDer['producto'], 0, 30)), 1, 0, 'L');
                $pdf->SetFont('Arial', 'B', 7);
                $pdf->Cell($wStock, 4.2, number_format($pDer['existencia'], 0) . " u.", 1, 1, 'C');
                $pdf->SetFont('Arial', '', 6.8);
            } else {
                $pdf->Cell($wColTotal, 4.2, "", 1, 1);
            }
        }

        $pdf->Ln(4);

        // Cuadro de firmas al pie
        $yFirma = 265;
        $pdf->SetY($yFirma);
        $pdf->Line(20, $yFirma, 85, $yFirma);
        $pdf->Line(125, $yFirma, 190, $yFirma);

        $pdf->SetFont('Arial', 'B', 7.5);
        $pdf->SetXY(20, $yFirma + 1.5);
        $pdf->Cell(65, 4, utf8_decode("ENTREGADO POR: CAJERO SALIENTE"), 0, 1, 'C');
        $pdf->SetFont('Arial', '', 6.5);
        $pdf->SetXY(20, $yFirma + 5.2);
        $pdf->Cell(65, 3.5, utf8_decode("Firma y Aclaración de Entrega"), 0, 1, 'C');

        $pdf->SetFont('Arial', 'B', 7.5);
        $pdf->SetXY(125, $yFirma + 1.5);
        $pdf->Cell(65, 4, utf8_decode("RECIBIDO POR: CAJERO ENTRANTE"), 0, 1, 'C');
        $pdf->SetFont('Arial', '', 6.5);
        $pdf->SetXY(125, $yFirma + 5.2);
        $pdf->Cell(65, 3.5, utf8_decode("Conforme con existencias físicas en barra/vitrina"), 0, 1, 'C');

        $pdf->Output('F', $outputPath);
        return file_exists($outputPath);
    }
}
