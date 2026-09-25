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

    public function clasificarProducto($nombre) {
        $n = strtoupper($nombre);
        if (strpos($n, 'COMBO') !== false || strpos($n, 'PACEÑA') !== false || strpos($n, 'PACENA') !== false ||
            strpos($n, 'AMSTEL') !== false || strpos($n, 'HUARI') !== false || strpos($n, 'CONTI') !== false ||
            strpos($n, 'DUCAL') !== false || strpos($n, 'CORONA') !== false || strpos($n, 'PROST') !== false ||
            strpos($n, 'BURGUESA') !== false || strpos($n, 'BOHEM') !== false || strpos($n, 'HEINEKEN') !== false) {
            return 'CERVEZAS Y COMBOS';
        }
        if (strpos($n, 'SODA') !== false || strpos($n, 'AGUA') !== false || strpos($n, 'COCA') !== false ||
            strpos($n, 'POWER') !== false || strpos($n, 'MONSTER') !== false || strpos($n, 'ICE') !== false) {
            return 'SODAS Y AGUAS';
        }
        if (strpos($n, 'MESA') !== false || strpos($n, 'BILLAR') !== false || strpos($n, 'HORA') !== false) {
            return 'MESAS DE BILLAR';
        }
        if (strpos($n, 'BELDENT') !== false || strpos($n, 'CHUPETE') !== false || strpos($n, 'GROSSO') !== false ||
            strpos($n, 'MANI') !== false || strpos($n, 'PAPA') !== false || strpos($n, 'CHIPILO') !== false ||
            strpos($n, 'MOMENTO') !== false || strpos($n, 'CAMEL') !== false || strpos($n, 'ENCENDER') !== false) {
            return 'SNACKS Y TABACO';
        }
        return 'VARIOS';
    }

    public function obtenerDetalleProductosArqueo($codarqueo) {
        if (!$codarqueo) {
            return [
                'items' => [],
                'resumen_categorias' => [],
                'total_unidades' => 0,
                'total_bs' => 0,
                'observaciones_ventas' => []
            ];
        }

        $sql = "SELECT dv.codproducto, dv.producto, 
                       SUM(dv.cantventa) as cantidad, 
                       dv.precioventa, 
                       SUM(dv.valortotal) as valortotal,
                       GROUP_CONCAT(DISTINCT NULLIF(TRIM(v.observaciones), '') SEPARATOR ' | ') as obs_ventas
                FROM ventas v
                JOIN detalleventas dv ON v.codventa = dv.codventa
                WHERE v.codarqueo = :codarqueo
                GROUP BY dv.codproducto, dv.producto, dv.precioventa
                ORDER BY cantidad DESC";

        $stmt = $this->dbh->prepare($sql);
        $stmt->execute([':codarqueo' => $codarqueo]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $items = [];
        $resumenCat = [];
        $totalUnidades = 0;
        $totalBs = 0;
        $observacionesVentas = [];

        foreach ($rows as $r) {
            $cat = $this->clasificarProducto($r['producto']);
            $cant = floatval($r['cantidad']);
            $subt = floatval($r['valortotal']);

            $items[] = [
                'codproducto' => $r['codproducto'],
                'producto' => $r['producto'],
                'categoria' => $cat,
                'cantidad' => $cant,
                'precioventa' => floatval($r['precioventa']),
                'valortotal' => $subt
            ];

            if (!isset($resumenCat[$cat])) {
                $resumenCat[$cat] = ['unidades' => 0, 'total_bs' => 0];
            }
            $resumenCat[$cat]['unidades'] += $cant;
            $resumenCat[$cat]['total_bs'] += $subt;

            $totalUnidades += $cant;
            $totalBs += $subt;

            if (!empty($r['obs_ventas'])) {
                $observacionesVentas[] = $r['obs_ventas'];
            }
        }

        return [
            'items' => $items,
            'resumen_categorias' => $resumenCat,
            'total_unidades' => $totalUnidades,
            'total_bs' => $totalBs,
            'observaciones_ventas' => array_unique($observacionesVentas)
        ];
    }

    public function detectarAnomaliasTurno($arq, $detalleProds) {
        $alertas = [];
        if (!$arq) return $alertas;

        // 1. Duración de caja ultracorta
        if (!empty($arq['fechaapertura']) && !empty($arq['fechacierre'])) {
            $tAbre = strtotime($arq['fechaapertura']);
            $tCierra = strtotime($arq['fechacierre']);
            $minutos = round(($tCierra - $tAbre) / 60);
            if ($minutos > 0 && $minutos <= 20 && floatval($arq['efectivocaja']) > 200) {
                $alertas[] = "Caja exprés de solo {$minutos} min con venta de Bs. " . number_format($arq['efectivocaja'], 2) . ". Posible venta manual de ajuste forzado.";
            }
        }

        // 2. Glosas de manipulación o ajuste
        $textoRevisar = strtoupper(($arq['comentarios'] ?? '') . ' ' . implode(' ', $detalleProds['observaciones_ventas'] ?? []));
        if (preg_match('/(DEMAS|DEMÁS|AJUSTE|ERROR|SOBRANTE|FALTANTE|DESCUENTO STOCK)/i', $textoRevisar, $m)) {
            $alertas[] = "Detectada glosa de manipulación o ajuste de inventario: '{$m[0]}'.";
        }

        // 3. Diferencia de caja
        $dif = floatval($arq['diferencia']);
        if ($dif < 0) {
            $alertas[] = "Faltante de efectivo en gaveta: -Bs. " . number_format(abs($dif), 2);
        } elseif ($dif > 0) {
            $alertas[] = "Sobrante de efectivo en gaveta: +Bs. " . number_format($dif, 2);
        }

        // 4. Ventas atípicas masivas de sodas/aguas
        foreach ($detalleProds['items'] as $it) {
            if ($it['cantidad'] >= 20 && $it['categoria'] === 'SODAS Y AGUAS') {
                $alertas[] = "Volumen atípico de {$it['producto']} ({$it['cantidad']} u. en una sola sesión).";
            }
        }

        return $alertas;
    }

    /**
     * Genera el PDF 1: Cuadre Económico de Caja con Auditoría Forense de Productos
     */
    public function generarPdfCuadre($sucursal, $turno, $fecha, $outputPath) {
        $arq = $this->obtenerUltimoArqueo($sucursal['codsucursal']);
        $pagos = $arq ? $this->obtenerPagosPorMedio($arq['codarqueo']) : ['efectivo' => 0, 'qr' => 0, 'otros' => 0, 'total' => 0];
        $detProds = $this->obtenerDetalleProductosArqueo($arq['codarqueo'] ?? 0);
        $anomalias = $this->detectarAnomaliasTurno($arq, $detProds);

        $pdf = new PDF_Cuadre_Caja('P', 'mm', 'A4');
        $pdf->sucursal = $sucursal['nomsucursal'];
        $pdf->turno = $turno;
        $pdf->fecha = $fecha;
        $pdf->SetMargins(10, 8, 10);
        $pdf->SetAutoPageBreak(true, 12);
        $pdf->AddPage();

        $montoInicial = $arq ? floatval($arq['montoinicial']) : 0;
        $ventasEfectivo = $pagos['efectivo'];
        $ventasQr = $pagos['qr'];
        $egresos = $arq ? floatval($arq['egresos']) : 0;
        $dineroDeclarado = $arq ? floatval($arq['dineroefectivo']) : 0;
        $diferencia = $arq ? floatval($arq['diferencia']) : 0;

        $badge = ($diferencia == 0) ? "CUADRADO EXACTO [OK]" : (($diferencia > 0) ? "SOBRANTE (+Bs. " . number_format($diferencia, 2) . ")" : "FALTANTE (-Bs. " . number_format(abs($diferencia), 2) . ")");
        $color = ($diferencia >= 0) ? [16, 185, 129] : [220, 38, 38];

        // 1. Resumen de Recaudación
        $pdf->TituloBloque("1", "CONCILIACIÓN ECONÓMICA Y MEDIOS DE PAGO", $badge, $color);
        
        $pdf->SetFont('Arial', 'B', 7.5);
        $pdf->SetFillColor(226, 232, 240);
        $pdf->Cell(45, 4.8, utf8_decode("Concepto"), 1, 0, 'L', true);
        $pdf->Cell(25, 4.8, utf8_decode("Sistema (POS)"), 1, 0, 'R', true);
        $pdf->Cell(25, 4.8, utf8_decode("Físico / Declarado"), 1, 0, 'R', true);
        $pdf->Cell(25, 4.8, utf8_decode("Diferencia"), 1, 0, 'R', true);
        $pdf->Cell(70, 4.8, utf8_decode("Diagnóstico / Estado"), 1, 1, 'L', true);

        $pdf->SetFont('Arial', '', 7.2);
        $pdf->Cell(45, 4.2, utf8_decode("Fondo Inicial (Caja Chica)"), 1, 0, 'L');
        $pdf->Cell(25, 4.2, "Bs. " . number_format($montoInicial, 2), 1, 0, 'R');
        $pdf->Cell(25, 4.2, "Bs. " . number_format($montoInicial, 2), 1, 0, 'R');
        $pdf->Cell(25, 4.2, "Bs. 0.00", 1, 0, 'R');
        $pdf->Cell(70, 4.2, utf8_decode("Monto base verificado"), 1, 1, 'L');

        $pdf->Cell(45, 4.2, utf8_decode("Ventas en Efectivo"), 1, 0, 'L');
        $pdf->Cell(25, 4.2, "Bs. " . number_format($ventasEfectivo, 2), 1, 0, 'R');
        $pdf->Cell(25, 4.2, "Bs. " . number_format($dineroDeclarado, 2), 1, 0, 'R');
        $pdf->Cell(25, 4.2, "Bs. " . number_format($diferencia, 2), 1, 0, 'R');
        $pdf->Cell(70, 4.2, utf8_decode($badge), 1, 1, 'L');

        $pdf->Cell(45, 4.2, utf8_decode("Cobros por QR Bancario"), 1, 0, 'L');
        $pdf->Cell(25, 4.2, "Bs. " . number_format($ventasQr, 2), 1, 0, 'R');
        $pdf->Cell(25, 4.2, "Bs. " . number_format($ventasQr, 2), 1, 0, 'R');
        $pdf->Cell(25, 4.2, "Bs. 0.00", 1, 0, 'R');
        $pdf->Cell(70, 4.2, utf8_decode("Ingreso digital directo a cuenta"), 1, 1, 'L');

        $pdf->Cell(45, 4.2, utf8_decode("Egresos y Gastos de Caja"), 1, 0, 'L');
        $pdf->Cell(25, 4.2, "Bs. " . number_format($egresos, 2), 1, 0, 'R');
        $pdf->Cell(25, 4.2, "Bs. " . number_format($egresos, 2), 1, 0, 'R');
        $pdf->Cell(25, 4.2, "Bs. 0.00", 1, 0, 'R');
        $pdf->Cell(70, 4.2, utf8_decode("Gastos operativos rendidos"), 1, 1, 'L');

        $totalCaja = $ventasEfectivo + $ventasQr;
        $pdf->SetFont('Arial', 'B', 7.5);
        $pdf->SetFillColor(248, 250, 252);
        $pdf->Cell(45, 4.6, utf8_decode("TOTAL VENTAS DEL TURNO"), 1, 0, 'L', true);
        $pdf->Cell(25, 4.6, "Bs. " . number_format($totalCaja, 2), 1, 0, 'R', true);
        $pdf->Cell(25, 4.6, "Bs. " . number_format($dineroDeclarado + $ventasQr, 2), 1, 0, 'R', true);
        $pdf->Cell(25, 4.6, "Bs. " . number_format($diferencia, 2), 1, 0, 'R', true);
        $pdf->Cell(70, 4.6, utf8_decode("Facturación consolidada"), 1, 1, 'L', true);

        $pdf->Ln(2.5);

        // 2. Información del Arqueo y Comentarios del Cajero
        $pdf->TituloBloque("2", "DATOS DEL ARQUEO Y NOTAS DE CIERRE", "ARQUEO #" . ($arq['codarqueo'] ?? 'N/A'), [56, 189, 248]);
        $pdf->SetFont('Arial', '', 7);
        $comentario = !empty($arq['comentarios']) ? $arq['comentarios'] : "Sin notas especiales registradas por el cajero al momento del cierre.";
        $pdf->MultiCell(190, 3.8, utf8_decode("• Caja Asignada: " . ($arq['nomcaja'] ?? 'Caja Principal') . " | Apertura: " . ($arq['fechaapertura'] ?? 'N/A') . " | Cierre: " . ($arq['fechacierre'] ?? 'N/A') . "\n• Comentarios del Cajero: " . $comentario), 1, 'L');

        $pdf->Ln(2.5);

        // 3. AUDITORÍA DE PRODUCTOS VENDIDOS EN EL TURNO
        $badgeProd = count($anomalias) == 0 ? "STOCK REGULAR [OK]" : "OBSERVADO (" . count($anomalias) . " ALERTAS)";
        $colorBadgeProd = count($anomalias) == 0 ? [16, 185, 129] : [239, 68, 68];
        $pdf->TituloBloque("3", "AUDITORÍA DE PRODUCTOS VENDIDOS (" . $detProds['total_unidades'] . " U. | BS. " . number_format($detProds['total_bs'], 2) . ")", $badgeProd, $colorBadgeProd);

        // Alertas Forenses si existen
        if (!empty($anomalias)) {
            $pdf->SetFillColor(254, 242, 242);
            $pdf->SetDrawColor(239, 68, 68);
            $pdf->SetTextColor(185, 28, 28);
            $pdf->SetFont('Arial', 'B', 7);
            $textoAlertas = "[!] ALERTAS FORENSES DETECTADAS:\n" . implode("\n", array_map(function($a) { return "  • " . $a; }, $anomalias));
            $pdf->MultiCell(190, 3.6, utf8_decode($textoAlertas), 1, 'L', true);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Ln(1.5);
        }

        // Resumen por Categorías
        $pdf->SetFont('Arial', 'B', 6.8);
        $pdf->SetFillColor(241, 245, 249);
        $resumenTexto = "  Consolidado por Rubro: ";
        foreach ($detProds['resumen_categorias'] as $cat => $val) {
            $resumenTexto .= "{$cat}: " . number_format($val['unidades'], 0) . " u. (Bs. " . number_format($val['total_bs'], 2) . ")  |  ";
        }
        $pdf->Cell(190, 4.2, utf8_decode(rtrim($resumenTexto, " | ")), 1, 1, 'L', true);
        $pdf->Ln(1);

        // Tabla de ítems vendidos (máximo 12 ítems principales)
        $pdf->SetFont('Arial', 'B', 6.8);
        $pdf->SetFillColor(226, 232, 240);
        $pdf->Cell(20, 4.2, utf8_decode("Código"), 1, 0, 'C', true);
        $pdf->Cell(70, 4.2, utf8_decode("Producto"), 1, 0, 'L', true);
        $pdf->Cell(45, 4.2, utf8_decode("Categoría"), 1, 0, 'L', true);
        $pdf->Cell(20, 4.2, utf8_decode("Cantidad"), 1, 0, 'C', true);
        $pdf->Cell(15, 4.2, utf8_decode("P. Unit"), 1, 0, 'R', true);
        $pdf->Cell(20, 4.2, utf8_decode("Subtotal"), 1, 1, 'R', true);

        $pdf->SetFont('Arial', '', 6.6);
        $itemsAMostrar = array_slice($detProds['items'], 0, 10);
        foreach ($itemsAMostrar as $it) {
            $pdf->Cell(20, 3.8, utf8_decode(substr($it['codproducto'], 0, 10)), 1, 0, 'C');
            $pdf->Cell(70, 3.8, utf8_decode(substr($it['producto'], 0, 38)), 1, 0, 'L');
            $pdf->Cell(45, 3.8, utf8_decode(substr($it['categoria'], 0, 24)), 1, 0, 'L');
            $pdf->SetFont('Arial', 'B', 6.6);
            $pdf->Cell(20, 3.8, number_format($it['cantidad'], 0) . " u.", 1, 0, 'C');
            $pdf->SetFont('Arial', '', 6.6);
            $pdf->Cell(15, 3.8, number_format($it['precioventa'], 2), 1, 0, 'R');
            $pdf->Cell(20, 3.8, "Bs. " . number_format($it['valortotal'], 2), 1, 1, 'R');
        }

        if (count($detProds['items']) > 10) {
            $restantes = count($detProds['items']) - 10;
            $pdf->SetFont('Arial', 'I', 6.5);
            $pdf->SetTextColor(100, 116, 139);
            $pdf->Cell(190, 3.6, utf8_decode("... y {$restantes} productos adicionales detallados en el libro de ventas POS."), 1, 1, 'C');
            $pdf->SetTextColor(0, 0, 0);
        }

        $pdf->Ln(2.5);

        // 4. Dictamen y Firmas
        $dictamenBadge = (count($anomalias) == 0 && $diferencia == 0) ? "100% CUADRADO Y CONFORME" : "AUDITADO CON OBSERVACIONES OPERATIVAS";
        $dictamenColor = (count($anomalias) == 0 && $diferencia == 0) ? [16, 185, 129] : [220, 38, 38];
        $pdf->TituloBloque("4", "DICTAMEN PERICIAL Y CONFORMIDAD ADMINISTRATIVA", $dictamenBadge, $dictamenColor);
        $pdf->SetFont('Arial', '', 7);
        $pdf->MultiCell(190, 3.6, utf8_decode("El presente informe ha sido validado mediante conciliación cruzada de registros transaccionales en base de datos, ventas por comanda, desglose de inventario y declaraciones de cierre. Cualquier inconsistencia debe ser representada en un plazo máximo de 12 horas hábiles."), 0, 'J');

        $pdf->Ln(8);

        // Cuadro de firmas
        $yFirma = $pdf->GetY();
        if ($yFirma > 260) {
            $pdf->AddPage();
            $yFirma = 30;
        }
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
