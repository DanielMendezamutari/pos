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
        $this->Cell(130, 4, utf8_decode("Control Interno y Auditoría Joker POS | Validación de Turno"), 0, 1, 'L');

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

    function TituloBloque($num, $title, $badge = "", $badgeColor = [22, 101, 52]) {
        $this->SetFillColor(241, 245, 249);
        $this->SetTextColor(15, 23, 42);
        $this->SetDrawColor(203, 213, 225);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(135, 5, utf8_decode("  " . $num . ". " . $title), 0, 0, 'L', true);
        
        $this->SetFont('Arial', 'B', 7.5);
        if ($badge != "") {
            $this->SetTextColor($badgeColor[0], $badgeColor[1], $badgeColor[2]);
            $this->Cell(55, 5, utf8_decode($badge . " "), 0, 1, 'R', true);
        } else {
            $this->Cell(55, 5, "", 0, 1, 'R', true);
        }
        $this->Ln(1.2);
        // Resetear siempre el color a oscuro para que ninguna celda siguiente herede el color del badge
        $this->SetTextColor(30, 41, 59);
        $this->SetDrawColor(203, 213, 225);
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
        if (strpos($n, 'MESA') !== false || strpos($n, 'BILLAR') !== false || strpos($n, 'HORA') !== false) {
            return 'MESAS DE BILLAR';
        }
        if (strpos($n, 'GUANTE') !== false) {
            return 'GUANTES DE BILLAR';
        }
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
        if (strpos($n, 'BELDENT') !== false || strpos($n, 'CHUPETE') !== false || strpos($n, 'GROSSO') !== false ||
            strpos($n, 'MANI') !== false || strpos($n, 'PAPA') !== false || strpos($n, 'CHIPILO') !== false ||
            strpos($n, 'MOMENTO') !== false || strpos($n, 'CAMEL') !== false || strpos($n, 'ENCENDER') !== false ||
            strpos($n, 'DOBLON') !== false || strpos($n, 'PUSH') !== false || strpos($n, 'GOLAZO') !== false) {
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

        $totalBillarBs = isset($resumenCat['MESAS DE BILLAR']) ? $resumenCat['MESAS DE BILLAR']['total_bs'] : 0;

        return [
            'items' => $items,
            'resumen_categorias' => $resumenCat,
            'total_unidades' => $totalUnidades,
            'total_bs' => $totalBs,
            'total_billar_bs' => $totalBillarBs,
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
                $alertas[] = "Turno abierto y cerrado en solo {$minutos} minutos con venta de Bs. " . number_format($arq['efectivocaja'], 2) . ".";
            }
        }

        // 2. Glosas de manipulación o ajuste
        $textoRevisar = strtoupper(($arq['comentarios'] ?? '') . ' ' . implode(' ', $detalleProds['observaciones_ventas'] ?? []));
        if (preg_match('/(DEMAS|DEMÁS|AJUSTE|ERROR|SOBRANTE|FALTANTE|DESCUENTO STOCK)/i', $textoRevisar, $m)) {
            $alertas[] = "Nota registrada en el turno: '{$m[0]}'.";
        }

        // 3. Diferencia de caja
        $dif = floatval($arq['diferencia'] ?? 0);
        if ($dif < -5) {
            $alertas[] = "Faltante de efectivo en gaveta: Bs. " . number_format(abs($dif), 2);
        } elseif ($dif > 5) {
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
     * Obtiene las discrepancias entre el conteo físico a ciegas y el sistema POS
     */
    public function obtenerDiscrepanciasStockYProductos($codsucursal, $codarqueo, $fechaIso = null) {
        if (!$fechaIso) $fechaIso = date('Y-m-d');

        // 1. Buscar en detalle_conteo_inicial vinculado al arqueo o sucursal reciente
        $sql = "SELECT d.codproducto, d.producto, d.stock_sistema, d.cantidad_fisica, d.diferencia,
                       COALESCE(p.preciocompra, 0.00) as preciocompra,
                       COALESCE(p.precioxpublico, 0.00) as precioventa,
                       cid.idconteo, cid.fechaconteo
                FROM detalle_conteo_inicial d
                INNER JOIN conteo_inicial_diario cid ON d.idconteo = cid.idconteo
                LEFT JOIN productos p ON (d.idproducto = p.idproducto AND p.codsucursal = cid.codsucursal)
                WHERE cid.codsucursal = :codsucursal
                  AND (cid.codarqueo = :codarqueo OR DATE(cid.fechaconteo) = :fechaIso)
                ORDER BY cid.idconteo DESC";

        $stmt = $this->dbh->prepare($sql);
        $stmt->execute([
            ':codsucursal' => $codsucursal,
            ':codarqueo' => $codarqueo,
            ':fechaIso' => $fechaIso
        ]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Si no encontró por fecha exacta o arqueo, tomar el último conteo de la sucursal
        if (empty($rows)) {
            $sqlUltimo = "SELECT d.codproducto, d.producto, d.stock_sistema, d.cantidad_fisica, d.diferencia,
                                 COALESCE(p.preciocompra, 0.00) as preciocompra,
                                 COALESCE(p.precioxpublico, 0.00) as precioventa,
                                 cid.idconteo, cid.fechaconteo
                          FROM detalle_conteo_inicial d
                          INNER JOIN conteo_inicial_diario cid ON d.idconteo = cid.idconteo
                          LEFT JOIN productos p ON (d.idproducto = p.idproducto AND p.codsucursal = cid.codsucursal)
                          WHERE cid.codsucursal = :codsucursal
                            AND cid.idconteo = (SELECT MAX(idconteo) FROM conteo_inicial_diario WHERE codsucursal = :codsucursal2)";
            $stmtU = $this->dbh->prepare($sqlUltimo);
            $stmtU->execute([':codsucursal' => $codsucursal, ':codsucursal2' => $codsucursal]);
            $rows = $stmtU->fetchAll(PDO::FETCH_ASSOC);
        }

        if (empty($rows)) {
            return [
                'tiene_conteo' => false,
                'idconteo' => null,
                'fecha_conteo' => null,
                'faltantes' => [],
                'sobrantes' => [],
                'total_discrepancias' => 0,
                'costo_total_perdida' => 0,
                'estado' => 'PENDIENTE_CONTEO'
            ];
        }

        $idConteo = $rows[0]['idconteo'];
        $fechaConteo = $rows[0]['fechaconteo'];
        $faltantes = [];
        $sobrantes = [];
        $costoTotalPerdida = 0;

        foreach ($rows as $r) {
            $dif = floatval($r['diferencia']);
            if (abs($dif) < 0.01) continue;

            $costoUnit = floatval($r['preciocompra']);
            if ($costoUnit <= 0) $costoUnit = floatval($r['precioventa']) * 0.7;

            $item = [
                'codproducto' => $r['codproducto'],
                'producto' => $r['producto'],
                'stock_sistema' => floatval($r['stock_sistema']),
                'cantidad_fisica' => floatval($r['cantidad_fisica']),
                'diferencia' => $dif,
                'costo_unit' => $costoUnit,
                'costo_total' => abs($dif) * $costoUnit
            ];

            if ($dif < 0) {
                $costoTotalPerdida += abs($dif) * $costoUnit;
                $faltantes[] = $item;
            } else {
                $sobrantes[] = $item;
            }
        }

        $estado = 'CUADRADO_EXACTO';
        if (!empty($faltantes) || !empty($sobrantes)) {
            $estado = 'DISCREPANCIAS_DETECTADAS';
            // Ordenar por mayor impacto económico (costo total de pérdida)
            usort($faltantes, fn($a, $b) => $b['costo_total'] <=> $a['costo_total']);
            usort($sobrantes, fn($a, $b) => $b['costo_total'] <=> $a['costo_total']);
        }

        return [
            'tiene_conteo' => true,
            'idconteo' => $idConteo,
            'fecha_conteo' => $fechaConteo,
            'faltantes' => $faltantes,
            'sobrantes' => $sobrantes,
            'total_discrepancias' => count($faltantes) + count($sobrantes),
            'costo_total_perdida' => $costoTotalPerdida,
            'estado' => $estado
        ];
    }

    /**
     * Construye un mensaje ejecutivo completo, altamente estructurado y con cruces
     * para enviar individualmente por sucursal a WhatsApp (1 mensaje por sucursal y por cierre).
     */
    public function generarMensajeAuditoriaSucursal($sucursal, $turno, $fechaHoy, $fechaIso) {
        $cod = $sucursal['codsucursal'];
        $nombre = strtoupper(trim($sucursal['nomsucursal']));
        
        $arq = $this->obtenerUltimoArqueo($cod);
        $pagos = $arq ? $this->obtenerPagosPorMedio($arq['codarqueo']) : ['efectivo' => 0, 'qr' => 0, 'otros' => 0, 'total' => 0];
        $detProds = $this->obtenerDetalleProductosArqueo($arq['codarqueo'] ?? 0);
        $anomalias = $this->detectarAnomaliasTurno($arq, $detProds);
        $disc = $this->obtenerDiscrepanciasStockYProductos($cod, $arq['codarqueo'] ?? 0, $fechaIso);

        $dif = $arq ? floatval($arq['diferencia']) : 0;
        $efectivo = $pagos['efectivo'];
        $qr = $pagos['qr'];
        $otros = $pagos['otros'];
        $totalRecaudado = $efectivo + $qr + $otros;
        $dineroCajaDeclarado = $arq ? floatval($arq['dineroefectivo']) : $efectivo;
        $egresos = $arq ? floatval($arq['egresos']) : 0;
        $nomCaja = $arq['nomcaja'] ?? 'Caja';
        $codArqueo = $arq['codarqueo'] ?? 'N/A';
        $apertura = !empty($arq['fechaapertura']) ? date('d/m H:i', strtotime($arq['fechaapertura'])) : 'N/A';
        $cierre = !empty($arq['fechacierre']) ? date('d/m H:i', strtotime($arq['fechacierre'])) : 'N/A';

        $iconoTurno = (stripos($turno, 'Noche') !== false) ? '🌙' : '☀️';
        $relevoTurno = (stripos($turno, 'Noche') !== false) ? 'Turno Tarde' : 'Turno Noche';

        $msg = "🏢 *{$nombre} - AUDITORÍA Y CRUCE DE CIERRE*\n";
        $msg .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        $msg .= "{$iconoTurno} *Turno:* {$turno} (Relevo {$relevoTurno})\n";
        $msg .= "📅 *Fecha:* {$fechaHoy} | *Hora Emisión:* " . date('H:i') . "\n";
        $msg .= "👤 *Caja:* {$nomCaja} | *Arqueo:* #{$codArqueo}\n";
        $msg .= "🕒 *Período:* {$apertura} ➔ {$cierre}\n\n";

        // 1. Balance Económico
        $msg .= "💰 *BALANCE ECONÓMICO Y FORMAS DE PAGO:*\n";
        $msg .= "  • Efectivo declarado en caja: Bs. " . number_format($dineroCajaDeclarado, 2) . "\n";
        $msg .= "  • Cobros verificados por QR: Bs. " . number_format($qr, 2) . "\n";
        if ($otros > 0) {
            $msg .= "  • Otros medios de pago: Bs. " . number_format($otros, 2) . "\n";
        }
        if ($egresos > 0) {
            $msg .= "  • Gastos / Egresos autorizados: Bs. " . number_format($egresos, 2) . "\n";
        }
        $msg .= "  • Total Recaudado (Ventas): Bs. " . number_format($totalRecaudado, 2) . "\n";

        if ($dif == 0) {
            $msg .= "  💵 *Diferencia de Caja:* Cuadrado exacto (Sin faltantes) ✅\n";
        } elseif ($dif < 0) {
            $msg .= "  💵 *Diferencia de Caja:* 🔴 *FALTANTE DE Bs. " . number_format(abs($dif), 2) . "* (Cajero debe justificar/reponer)\n";
        } else {
            $msg .= "  💵 *Diferencia de Caja:* 🟡 *SOBRANTE DE +Bs. " . number_format($dif, 2) . "*\n";
        }

        // 2. Mesas de Billar
        if (!empty($detProds['total_billar_bs']) && $detProds['total_billar_bs'] > 0) {
            $msg .= "\n🎱 *MESAS DE BILLAR:*\n";
            $msg .= "  • Tiempo de juego cobrado: Bs. " . number_format($detProds['total_billar_bs'], 2) . "\n";
        }

        // 3. Venta de Productos
        $lineasProds = [];
        foreach ($detProds['resumen_categorias'] as $cat => $val) {
            if ($cat === 'MESAS DE BILLAR') continue;
            if ($cat === 'CERVEZAS Y COMBOS') {
                $lineasProds[] = "  • Cervezas y Combos: " . number_format($val['unidades'], 0) . " botellas (Bs. " . number_format($val['total_bs'], 2) . ")";
            } elseif ($cat === 'SODAS Y AGUAS') {
                $lineasProds[] = "  • Sodas y Aguas: " . number_format($val['unidades'], 0) . " botellas (Bs. " . number_format($val['total_bs'], 2) . ")";
            } elseif ($cat === 'GUANTES DE BILLAR') {
                $lineasProds[] = "  • Guantes de billar: " . number_format($val['unidades'], 0) . " pares (Bs. " . number_format($val['total_bs'], 2) . ")";
            } elseif ($cat === 'SNACKS Y TABACO') {
                $lineasProds[] = "  • Snacks y Cigarros: " . number_format($val['unidades'], 0) . " unidades (Bs. " . number_format($val['total_bs'], 2) . ")";
            } else {
                $lineasProds[] = "  • " . ucfirst(strtolower($cat)) . ": " . number_format($val['unidades'], 0) . " unidades (Bs. " . number_format($val['total_bs'], 2) . ")";
            }
        }
        if (!empty($lineasProds)) {
            $msg .= "\n📦 *VENTA DE PRODUCTOS EN EL TURNO:*\n" . implode("\n", $lineasProds) . "\n";
        }

        // 4. Cruce de Stock Físico vs Sistema (Mermas, Faltantes y Sobrantes)
        $msg .= "\n🔍 *CRUCE DE STOCK FÍSICO VS SISTEMA (CONTEO A CIEGAS):*\n";
        if ($disc['estado'] === 'DISCREPANCIAS_DETECTADAS') {
            if (!empty($disc['faltantes'])) {
                $cantF = count($disc['faltantes']);
                $msg .= "  🔴 *FALTANTES DETECTADOS / MERMAS ({$cantF} productos):*\n";
                $topF = array_slice($disc['faltantes'], 0, 8);
                foreach ($topF as $f) {
                    $prodNom = trim($f['producto']);
                    $cantU = number_format(abs($f['diferencia']), 0);
                    $costoTot = number_format($f['costo_total'], 2);
                    $stockSis = number_format($f['stock_sistema'], 0);
                    $stockFis = number_format($f['cantidad_fisica'], 0);
                    $msg .= "    • {$prodNom}: -{$cantU} u. (Sis: {$stockSis} | Fís: {$stockFis}) ➔ Pérdida: Bs. {$costoTot}\n";
                }
                if ($cantF > 8) {
                    $msg .= "    _... y " . ($cantF - 8) . " faltantes menores más (ver PDF adjunto)._\n";
                }
                $msg .= "  📉 *Pérdida Total en Faltantes:* Bs. " . number_format($disc['costo_total_perdida'], 2) . "\n";
            }

            if (!empty($disc['sobrantes'])) {
                $cantS = count($disc['sobrantes']);
                $msg .= "  🟡 *SOBRANTES DETECTADOS ({$cantS} productos):*\n";
                $topS = array_slice($disc['sobrantes'], 0, 5);
                foreach ($topS as $s) {
                    $prodNom = trim($s['producto']);
                    $cantU = number_format($s['diferencia'], 0);
                    $stockSis = number_format($s['stock_sistema'], 0);
                    $stockFis = number_format($s['cantidad_fisica'], 0);
                    $msg .= "    • {$prodNom}: +{$cantU} u. (Sis: {$stockSis} | Fís: {$stockFis})\n";
                }
                if ($cantS > 5) {
                    $msg .= "    _... y " . ($cantS - 5) . " sobrantes más (ver PDF adjunto)._\n";
                }
            }
        } elseif ($disc['estado'] === 'CUADRADO_EXACTO') {
            $msg .= "  ✅ *Stock 100% Cuadrado:* Conteo físico coincide exactamente con el sistema (Sin mermas ni faltantes).\n";
        } else {
            $msg .= "  ⏳ *Stock:* Sin conteo físico registrado en este turno.\n";
        }

        // 5. Comentarios y Observaciones
        $notas = [];
        if (!empty($arq['comentarios'])) {
            $notas[] = "Nota del Cajero: \"" . trim($arq['comentarios']) . "\"";
        }
        if (!empty($anomalias)) {
            foreach ($anomalias as $anom) {
                if (stripos($anom, 'Faltante de efectivo') !== false || stripos($anom, 'Sobrante de efectivo') !== false) continue;
                $notas[] = $anom;
            }
        }
        if (!empty($notas)) {
            $msg .= "\n⚠️ *OBSERVACIONES / ALERTAS:*\n";
            foreach ($notas as $n) {
                $msg .= "  • {$n}\n";
            }
        }

        $msg .= "\n━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        $msg .= "📎 _Se adjunta el Informe Oficial de Auditoría de {$nombre} en PDF (Pág. 1 de 1)._";

        return $msg;
    }

    /**
     * Genera el PDF Oficial de Cuadre de Caja y Control de Mermas de Productos (1 sola hoja, alto contraste)
     */
    public function generarPdfCuadre($sucursal, $turno, $fecha, $outputPath) {
        $arq = $this->obtenerUltimoArqueo($sucursal['codsucursal']);
        $pagos = $arq ? $this->obtenerPagosPorMedio($arq['codarqueo']) : ['efectivo' => 0, 'qr' => 0, 'otros' => 0, 'total' => 0];
        $detProds = $this->obtenerDetalleProductosArqueo($arq['codarqueo'] ?? 0);
        $anomalias = $this->detectarAnomaliasTurno($arq, $detProds);
        $discrepancias = $this->obtenerDiscrepanciasStockYProductos($sucursal['codsucursal'], $arq['codarqueo'] ?? 0);

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
        $dineroDeclarado = $arq ? floatval($arq['dineroefectivo']) : 0;
        $diferencia = $arq ? floatval($arq['diferencia']) : 0;

        $badge = ($diferencia == 0) ? "CUADRADO EXACTO [OK]" : (($diferencia > 0) ? "SOBRANTE (+Bs. " . number_format($diferencia, 2) . ")" : "FALTANTE (-Bs. " . number_format(abs($diferencia), 2) . ")");
        $badgeColor = ($diferencia == 0) ? [22, 101, 52] : (($diferencia > 0) ? [161, 98, 7] : [185, 28, 28]);

        // 1. Resumen de Recaudación (Alto Contraste)
        $pdf->TituloBloque("1", "CONCILIACIÓN ECONÓMICA Y MEDIOS DE PAGO", $badge, $badgeColor);
        
        $pdf->SetFont('Arial', 'B', 7.5);
        $pdf->SetFillColor(241, 245, 249);
        $pdf->SetTextColor(15, 23, 42);
        $pdf->SetDrawColor(203, 213, 225);
        $pdf->Cell(45, 4.6, utf8_decode("Concepto"), 1, 0, 'L', true);
        $pdf->Cell(25, 4.6, utf8_decode("Sistema (POS)"), 1, 0, 'R', true);
        $pdf->Cell(25, 4.6, utf8_decode("Físico / Declarado"), 1, 0, 'R', true);
        $pdf->Cell(25, 4.6, utf8_decode("Diferencia"), 1, 0, 'R', true);
        $pdf->Cell(70, 4.6, utf8_decode("Diagnóstico / Estado"), 1, 1, 'L', true);

        $pdf->SetFont('Arial', '', 7.2);
        $pdf->SetTextColor(30, 41, 59);

        // Fondo inicial
        $pdf->Cell(45, 4.0, utf8_decode("Fondo Inicial (Caja Chica)"), 1, 0, 'L');
        $pdf->Cell(25, 4.0, "Bs. " . number_format($montoInicial, 2), 1, 0, 'R');
        $pdf->Cell(25, 4.0, "Bs. " . number_format($montoInicial, 2), 1, 0, 'R');
        $pdf->Cell(25, 4.0, "Bs. 0.00", 1, 0, 'R');
        $pdf->Cell(70, 4.0, utf8_decode("Monto base verificado"), 1, 1, 'L');

        // Ventas Efectivo
        $pdf->Cell(45, 4.0, utf8_decode("Ventas en Efectivo"), 1, 0, 'L');
        $pdf->Cell(25, 4.0, "Bs. " . number_format($ventasEfectivo, 2), 1, 0, 'R');
        $pdf->Cell(25, 4.0, "Bs. " . number_format($dineroDeclarado, 2), 1, 0, 'R');
        
        if ($diferencia == 0) {
            $pdf->SetTextColor(22, 101, 52);
            $pdf->Cell(25, 4.0, "Bs. 0.00", 1, 0, 'R');
            $pdf->Cell(70, 4.0, utf8_decode("Cuadrado exacto sin faltantes [OK]"), 1, 1, 'L');
        } elseif ($diferencia < 0) {
            $pdf->SetFillColor(254, 242, 242);
            $pdf->SetTextColor(185, 28, 28);
            $pdf->SetFont('Arial', 'B', 7.2);
            $pdf->Cell(25, 4.0, "-Bs. " . number_format(abs($diferencia), 2), 1, 0, 'R', true);
            $pdf->Cell(70, 4.0, utf8_decode("FALTANTE DE EFECTIVO EN CAJA"), 1, 1, 'L', true);
            $pdf->SetFont('Arial', '', 7.2);
        } else {
            $pdf->SetFillColor(254, 252, 232);
            $pdf->SetTextColor(161, 98, 7);
            $pdf->SetFont('Arial', 'B', 7.2);
            $pdf->Cell(25, 4.0, "+Bs. " . number_format($diferencia, 2), 1, 0, 'R', true);
            $pdf->Cell(70, 4.0, utf8_decode("SOBRANTE DE EFECTIVO"), 1, 1, 'L', true);
            $pdf->SetFont('Arial', '', 7.2);
        }
        $pdf->SetTextColor(30, 41, 59);

        // QR Bancario
        $pdf->Cell(45, 4.0, utf8_decode("Cobros por QR Bancario"), 1, 0, 'L');
        $pdf->Cell(25, 4.0, "Bs. " . number_format($ventasQr, 2), 1, 0, 'R');
        $pdf->Cell(25, 4.0, "Bs. " . number_format($ventasQr, 2), 1, 0, 'R');
        $pdf->Cell(25, 4.0, "Bs. 0.00", 1, 0, 'R');
        $pdf->Cell(70, 4.0, utf8_decode("Ingreso digital directo a cuenta"), 1, 1, 'L');

        // Gastos / Egresos
        $pdf->Cell(45, 4.0, utf8_decode("Egresos y Gastos de Caja"), 1, 0, 'L');
        $pdf->Cell(25, 4.0, "Bs. " . number_format($egresos, 2), 1, 0, 'R');
        $pdf->Cell(25, 4.0, "Bs. " . number_format($egresos, 2), 1, 0, 'R');
        $pdf->Cell(25, 4.0, "Bs. 0.00", 1, 0, 'R');
        $pdf->Cell(70, 4.0, utf8_decode("Gastos operativos rendidos"), 1, 1, 'L');

        // Total
        $totalCaja = $ventasEfectivo + $ventasQr;
        $pdf->SetFont('Arial', 'B', 7.5);
        $pdf->SetFillColor(241, 245, 249);
        $pdf->SetTextColor(15, 23, 42);
        $pdf->Cell(45, 4.5, utf8_decode("TOTAL VENTAS DEL TURNO"), 1, 0, 'L', true);
        $pdf->Cell(25, 4.5, "Bs. " . number_format($totalCaja, 2), 1, 0, 'R', true);
        $pdf->Cell(25, 4.5, "Bs. " . number_format($dineroDeclarado + $ventasQr, 2), 1, 0, 'R', true);
        $pdf->Cell(25, 4.5, "Bs. " . number_format($diferencia, 2), 1, 0, 'R', true);
        $pdf->Cell(70, 4.5, utf8_decode("Facturación consolidada del turno"), 1, 1, 'L', true);

        $pdf->Ln(2.0);

        // 2. Información del Arqueo y Comentarios
        $pdf->TituloBloque("2", "DATOS DEL ARQUEO Y NOTAS DE CIERRE", "ARQUEO #" . ($arq['codarqueo'] ?? 'N/A'), [2, 132, 199]);
        $pdf->SetFont('Arial', '', 7.0);
        $pdf->SetTextColor(30, 41, 59);
        $comentario = !empty($arq['comentarios']) ? $arq['comentarios'] : "Sin notas especiales registradas por el cajero al momento del cierre.";
        $pdf->MultiCell(190, 3.6, utf8_decode("[-] Caja: " . ($arq['nomcaja'] ?? 'Caja Principal') . " | Apertura: " . ($arq['fechaapertura'] ?? 'N/A') . " | Cierre: " . ($arq['fechacierre'] ?? 'N/A') . "\n[-] Comentarios del Cajero: " . $comentario), 1, 'L');

        $pdf->Ln(2.0);

        // 3. PRODUCTOS A CUADRAR Y MERMAS DE STOCK (LO MÁS IMPORTANTE PARA EL USUARIO)
        if ($discrepancias['estado'] === 'DISCREPANCIAS_DETECTADAS') {
            $badgeProd = count($discrepancias['faltantes']) . " FALTANTES (" . count($discrepancias['sobrantes']) . " SOBRANTES)";
            $colorBadgeProd = [185, 28, 28]; // Dark red
        } elseif ($discrepancias['estado'] === 'CUADRADO_EXACTO') {
            $badgeProd = "STOCK CUADRADO EXACTO [OK]";
            $colorBadgeProd = [22, 101, 52]; // Dark green
        } else {
            $badgeProd = "PENDIENTE CONTEO FISICO";
            $colorBadgeProd = [161, 98, 7]; // Amber
        }

        $pdf->TituloBloque("3", "CONTROL DE PRODUCTOS A CUADRAR Y MERMAS DE STOCK", $badgeProd, $colorBadgeProd);

        if ($discrepancias['estado'] === 'DISCREPANCIAS_DETECTADAS') {
            $pdf->SetFont('Arial', 'B', 7.0);
            $pdf->SetFillColor(241, 245, 249);
            $pdf->SetTextColor(15, 23, 42);
            $pdf->Cell(22, 4.2, utf8_decode("Código"), 1, 0, 'C', true);
            $pdf->Cell(68, 4.2, utf8_decode("Producto"), 1, 0, 'L', true);
            $pdf->Cell(25, 4.2, utf8_decode("Sistema (POS)"), 1, 0, 'R', true);
            $pdf->Cell(25, 4.2, utf8_decode("Físico Contado"), 1, 0, 'R', true);
            $pdf->Cell(25, 4.2, utf8_decode("Diferencia"), 1, 0, 'R', true);
            $pdf->Cell(25, 4.2, utf8_decode("Estado"), 1, 1, 'C', true);

            $pdf->SetFont('Arial', '', 6.8);
            foreach ($discrepancias['faltantes'] as $it) {
                $pdf->SetTextColor(30, 41, 59);
                $pdf->Cell(22, 3.8, utf8_decode(substr($it['codproducto'], 0, 10)), 1, 0, 'C');
                $pdf->Cell(68, 3.8, utf8_decode(substr($it['producto'], 0, 36)), 1, 0, 'L');
                $pdf->Cell(25, 3.8, number_format($it['stock_sistema'], 0) . " u.", 1, 0, 'R');
                $pdf->Cell(25, 3.8, number_format($it['cantidad_fisica'], 0) . " u.", 1, 0, 'R');
                
                // Destacar faltante en rojo oscuro
                $pdf->SetFont('Arial', 'B', 6.8);
                $pdf->SetTextColor(185, 28, 28);
                $pdf->SetFillColor(254, 242, 242);
                $pdf->Cell(25, 3.8, number_format($it['diferencia'], 0) . " u.", 1, 0, 'R', true);
                $pdf->Cell(25, 3.8, utf8_decode("FALTANTE"), 1, 1, 'C', true);
                $pdf->SetFont('Arial', '', 6.8);
                $pdf->SetTextColor(30, 41, 59);
            }

            foreach ($discrepancias['sobrantes'] as $it) {
                $pdf->SetTextColor(30, 41, 59);
                $pdf->Cell(22, 3.8, utf8_decode(substr($it['codproducto'], 0, 10)), 1, 0, 'C');
                $pdf->Cell(68, 3.8, utf8_decode(substr($it['producto'], 0, 36)), 1, 0, 'L');
                $pdf->Cell(25, 3.8, number_format($it['stock_sistema'], 0) . " u.", 1, 0, 'R');
                $pdf->Cell(25, 3.8, number_format($it['cantidad_fisica'], 0) . " u.", 1, 0, 'R');
                
                // Sobrante en ámbar oscuro
                $pdf->SetFont('Arial', 'B', 6.8);
                $pdf->SetTextColor(161, 98, 7);
                $pdf->SetFillColor(254, 252, 232);
                $pdf->Cell(25, 3.8, "+" . number_format($it['diferencia'], 0) . " u.", 1, 0, 'R', true);
                $pdf->Cell(25, 3.8, utf8_decode("SOBRANTE"), 1, 1, 'C', true);
                $pdf->SetFont('Arial', '', 6.8);
                $pdf->SetTextColor(30, 41, 59);
            }
        } elseif ($discrepancias['estado'] === 'CUADRADO_EXACTO') {
            $pdf->SetFillColor(240, 253, 244);
            $pdf->SetTextColor(22, 101, 52);
            $pdf->SetFont('Arial', 'B', 7.2);
            $pdf->Cell(190, 5.5, utf8_decode("  [OK] CONTEO FISICO EXACTO: Todos los productos contados coinciden con el inventario del POS."), 1, 1, 'L', true);
            $pdf->SetTextColor(30, 41, 59);
        } else {
            $pdf->SetFillColor(254, 252, 232);
            $pdf->SetTextColor(161, 98, 7);
            $pdf->SetFont('Arial', '', 7.0);
            $pdf->Cell(190, 5.5, utf8_decode("  [PENDIENTE] Sin planilla de conteo de relevo registrada en el sistema. Los cajeros deben registrar el conteo."), 1, 1, 'L', true);
            $pdf->SetTextColor(30, 41, 59);
        }

        $pdf->Ln(2.0);

        // 4. RESUMEN DE VENTAS Y ROTACIÓN DEL TURNO
        $pdf->TituloBloque("4", "RESUMEN DE VENTAS Y ROTACIÓN (" . $detProds['total_unidades'] . " U. | BS. " . number_format($detProds['total_bs'], 2) . ")", "ROTACIÓN", [2, 132, 199]);
        
        $pdf->SetFont('Arial', 'B', 6.8);
        $pdf->SetFillColor(241, 245, 249);
        $pdf->SetTextColor(30, 41, 59);
        $resumenTexto = "  Rubros: ";
        foreach ($detProds['resumen_categorias'] as $cat => $val) {
            $resumenTexto .= "{$cat}: " . number_format($val['unidades'], 0) . " u. (Bs. " . number_format($val['total_bs'], 2) . ")  |  ";
        }
        $pdf->Cell(190, 4.0, utf8_decode(rtrim($resumenTexto, " | ")), 1, 1, 'L', true);
        $pdf->Ln(1);

        // Tabla de ítems más vendidos (máximo 6 ítems para garantizar 1 sola página perfecta)
        $pdf->SetFont('Arial', 'B', 6.8);
        $pdf->SetFillColor(226, 232, 240);
        $pdf->SetTextColor(15, 23, 42);
        $pdf->Cell(22, 3.8, utf8_decode("Código"), 1, 0, 'C', true);
        $pdf->Cell(78, 3.8, utf8_decode("Producto"), 1, 0, 'L', true);
        $pdf->Cell(45, 3.8, utf8_decode("Categoría"), 1, 0, 'L', true);
        $pdf->Cell(20, 3.8, utf8_decode("Cantidad"), 1, 0, 'C', true);
        $pdf->Cell(25, 3.8, utf8_decode("Subtotal"), 1, 1, 'R', true);

        $pdf->SetFont('Arial', '', 6.6);
        $itemsAMostrar = array_slice($detProds['items'], 0, 6);
        foreach ($itemsAMostrar as $it) {
            $pdf->SetTextColor(30, 41, 59);
            $pdf->Cell(22, 3.6, utf8_decode(substr($it['codproducto'], 0, 10)), 1, 0, 'C');
            $pdf->Cell(78, 3.6, utf8_decode(substr($it['producto'], 0, 40)), 1, 0, 'L');
            $pdf->Cell(45, 3.6, utf8_decode(substr($it['categoria'], 0, 24)), 1, 0, 'L');
            $pdf->SetFont('Arial', 'B', 6.6);
            $pdf->Cell(20, 3.6, number_format($it['cantidad'], 0) . " u.", 1, 0, 'C');
            $pdf->SetFont('Arial', '', 6.6);
            $pdf->Cell(25, 3.6, "Bs. " . number_format($it['valortotal'], 2), 1, 1, 'R');
        }

        $pdf->Ln(2.0);

        // 5. Dictamen y Firmas
        $dictamenBadge = ($diferencia == 0 && empty($discrepancias['faltantes'])) ? "100% CUADRADO Y CONFORME" : "AUDITADO CON OBSERVACIONES";
        $dictamenColor = ($diferencia == 0 && empty($discrepancias['faltantes'])) ? [22, 101, 52] : [185, 28, 28];
        $pdf->TituloBloque("5", "DICTAMEN PERICIAL Y CONFORMIDAD ADMINISTRATIVA", $dictamenBadge, $dictamenColor);
        $pdf->SetFont('Arial', '', 6.8);
        $pdf->SetTextColor(71, 85, 105);
        $pdf->MultiCell(190, 3.2, utf8_decode("Validado mediante conciliación cruzada de registros en BD, ventas por comanda, conteo ciego de relevo y declaraciones de cierre. Cualquier inconsistencia debe ser representada en un plazo máximo de 12 horas hábiles."), 0, 'J');

        $pdf->Ln(6);

        // Cuadro de firmas con texto oscuro
        $yFirma = $pdf->GetY();
        if ($yFirma > 268) {
            $yFirma = 265;
        }
        $pdf->SetDrawColor(100, 116, 139);
        $pdf->Line(20, $yFirma, 85, $yFirma);
        $pdf->Line(125, $yFirma, 190, $yFirma);

        $pdf->SetFont('Arial', 'B', 7.5);
        $pdf->SetTextColor(15, 23, 42);
        $pdf->SetXY(20, $yFirma + 1.2);
        $pdf->Cell(65, 3.8, utf8_decode("FIRMA CAJERO SALIENTE"), 0, 1, 'C');
        $pdf->SetFont('Arial', '', 6.8);
        $pdf->SetTextColor(100, 116, 139);
        $pdf->SetXY(20, $yFirma + 4.8);
        $pdf->Cell(65, 3.2, utf8_decode("Declaración Jurada de Entrega"), 0, 1, 'C');

        $pdf->SetFont('Arial', 'B', 7.5);
        $pdf->SetTextColor(15, 23, 42);
        $pdf->SetXY(125, $yFirma + 1.2);
        $pdf->Cell(65, 3.8, utf8_decode("ADMINISTRACIÓN / CONTROL INTERNO"), 0, 1, 'C');
        $pdf->SetFont('Arial', '', 6.8);
        $pdf->SetTextColor(100, 116, 139);
        $pdf->SetXY(125, $yFirma + 4.8);
        $pdf->Cell(65, 3.2, utf8_decode("Certificación de Arqueo Joker POS"), 0, 1, 'C');

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

    /**
     * Analiza las fotos subidas a la sucursal usando Gemini Vision y cruza cuaderno/inventario
     */
    public function auditarFotosSucursalConIA($sucursal, $codarqueo, $fechaIso = null) {
        if (!$fechaIso) $fechaIso = date('Y-m-d');
        require_once dirname(__DIR__) . '/class/GeminiVisionAuditor.php';
        $auditor = new GeminiVisionAuditor();

        $nombreSucursal = strtoupper($sucursal['nomsucursal'] ?? '');
        $codsucursal = intval($sucursal['codsucursal'] ?? 0);
        $carpetaSuc = 'CENTRAL';
        if (strpos($nombreSucursal, 'MEGA') !== false) $carpetaSuc = 'MEGA';
        elseif (strpos($nombreSucursal, 'ULTRA') !== false) $carpetaSuc = 'ULTRA';
        elseif (strpos($nombreSucursal, 'EXPRESS') !== false) $carpetaSuc = 'EXPRESS';

        $baseFotos = dirname(__DIR__) . '/auditoria_fotos';
        $dirSuc = $baseFotos . '/' . $fechaIso . '/' . $carpetaSuc;
        $fotos = [];
        if (is_dir($dirSuc)) {
            $fotos = glob($dirSuc . '/*.{jpg,jpeg,png,webp}', GLOB_BRACE) ?: [];
        }

        if (empty($fotos)) {
            return [
                'tiene_analisis' => false,
                'mensaje' => 'Sin fotografías subidas para esta sucursal en la fecha.'
            ];
        }

        // Analizar las fotos de cierre disponibles (hasta 2 fotos para consolidar cuaderno de mesas + sobre de dinero/gastos)
        rsort($fotos);
        $fotosAnalizar = array_slice($fotos, 0, 2);

        $extraccionConsolidada = [
            'productos_anotados' => [],
            'stock_fisico_contado' => [],
            'gastos_o_vales' => [],
            'total_declarado' => 0,
            'total_efectivo_declarado' => 0,
            'total_qr_declarado' => 0,
            'tipo_documento' => 'LIBRETA_VENTAS',
            'alertas_visuales' => []
        ];

        $algunaAnalizada = false;
        foreach ($fotosAnalizar as $f) {
            $ext = $auditor->analizarFoto($f);
            if ($ext) {
                $algunaAnalizada = true;
                if (!empty($ext['productos_anotados'])) {
                    $extraccionConsolidada['productos_anotados'] = array_merge($extraccionConsolidada['productos_anotados'], $ext['productos_anotados']);
                }
                if (!empty($ext['stock_fisico_contado'])) {
                    $extraccionConsolidada['stock_fisico_contado'] = array_merge($extraccionConsolidada['stock_fisico_contado'], $ext['stock_fisico_contado']);
                }
                if (!empty($ext['gastos_o_vales'])) {
                    $extraccionConsolidada['gastos_o_vales'] = array_merge($extraccionConsolidada['gastos_o_vales'], $ext['gastos_o_vales']);
                }
                if (!empty($ext['total_declarado']) && $ext['total_declarado'] > $extraccionConsolidada['total_declarado']) {
                    $extraccionConsolidada['total_declarado'] = $ext['total_declarado'];
                }
                if (!empty($ext['total_efectivo_declarado']) && $ext['total_efectivo_declarado'] > $extraccionConsolidada['total_efectivo_declarado']) {
                    $extraccionConsolidada['total_efectivo_declarado'] = $ext['total_efectivo_declarado'];
                }
                if (!empty($ext['total_qr_declarado']) && $ext['total_qr_declarado'] > $extraccionConsolidada['total_qr_declarado']) {
                    $extraccionConsolidada['total_qr_declarado'] = $ext['total_qr_declarado'];
                }
                if (!empty($ext['alertas_visuales'])) {
                    $extraccionConsolidada['alertas_visuales'] = array_merge($extraccionConsolidada['alertas_visuales'], $ext['alertas_visuales']);
                }
            }
        }

        if (!$algunaAnalizada) {
            return [
                'tiene_analisis' => false,
                'mensaje' => 'No se pudo decodificar las fotos con Gemini Vision.'
            ];
        }

        $cruceCuaderno = $auditor->cruzarCuadernoVsPos($codarqueo, $extraccionConsolidada);
        $cruceInventario = $auditor->cruzarInventarioVsSistema($codsucursal, $extraccionConsolidada);

        $pagos = $codarqueo ? $this->obtenerPagosPorMedio($codarqueo) : ['total' => 0, 'efectivo' => 0, 'qr' => 0];
        $evaluacionManual = $auditor->evaluarCuadreManualVsPos($codarqueo, $extraccionConsolidada, $pagos['total'], $pagos['efectivo'], $pagos['qr']);

        return [
            'tiene_analisis' => true,
            'foto' => basename($fotosAnalizar[0]),
            'tipo_documento' => $extraccionConsolidada['tipo_documento'],
            'cruce_cuaderno' => $cruceCuaderno,
            'cruce_inventario' => $cruceInventario,
            'evaluacion_manual' => $evaluacionManual,
            'alertas_visuales' => $extraccionConsolidada['alertas_visuales']
        ];
    }
}
