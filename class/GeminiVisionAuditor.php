<?php
require_once __DIR__ . '/classconexion.php';

class GeminiVisionAuditor extends Db {
    private $apiKey;
    private $model = 'gemini-3.5-flash-lite';

    public function __construct($apiKey = null) {
        parent::__construct();
        if ($apiKey) {
            $this->apiKey = $apiKey;
        } elseif (defined('GEMINI_API_KEY')) {
            $this->apiKey = GEMINI_API_KEY;
        } else {
            $keyFile = dirname(__DIR__) . '/gemini_key.txt';
            $this->apiKey = file_exists($keyFile) ? trim(file_get_contents($keyFile)) : getenv('GEMINI_API_KEY');
        }
    }

    /**
     * Analiza una fotografía de auditoría y extrae datos estructurados en JSON
     */
    public function analizarFoto($imagePath) {
        if (!file_exists($imagePath)) {
            return null;
        }

        $imgData = base64_encode(file_get_contents($imagePath));
        $mimeType = 'image/jpeg';
        $ext = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));
        if ($ext === 'png') $mimeType = 'image/png';
        if ($ext === 'webp') $mimeType = 'image/webp';

        $prompt = <<<PROMPT
Eres un Auditor Forense experto de un sistema POS para locales de billar y barra ("Joker").
Analiza detalladamente esta fotografía tomada por un cajero o responsable de turno.
La fotografía puede ser:
1. "LIBRETA_VENTAS": Cuaderno manuscrito o libreta cuadriculada con anotaciones de mesas, consumos de cerveza, sodas, tragos y vales.
2. "INVENTARIO_FISICO": Planilla manuscrita o impresa de control de stock donde se cuenta la cantidad física de botellas/latas en heladeras.
3. "SOBRE_DINERO": Sobre o papel con el arqueo manual de efectivo (billetes, monedas, total recaudado).
4. "TICKET_POS": Ticket térmico emitido por la impresora de la caja.
5. "OTRO": Cualquier otra evidencia.

IMPORTANTE: Responde ÚNICAMENTE con un objeto JSON válido (sin formato markdown ```json, solo el JSON puro) con esta estructura exacta:
{
  "tipo_documento": "LIBRETA_VENTAS|INVENTARIO_FISICO|SOBRE_DINERO|TICKET_POS|OTRO",
  "sucursal_detectada": "CENTRAL|MEGA|ULTRA|EXPRESS|DESCONOCIDA",
  "turno_detectado": "TARDE|NOCHE|DESCONOCIDO",
  "responsable_o_cajero": "nombre o null",
  "fecha_detectada": "YYYY-MM-DD o null",
  "productos_anotados": [
    {
      "producto": "nombre normalizado (ej: PACEÑA, AMSTEL, AGUA 2L, SODA 2LT)",
      "cantidad": 0.0,
      "monto": 0.0,
      "nota": "mesa o detalle si existe"
    }
  ],
  "stock_fisico_contado": [
    {
      "producto": "nombre normalizado",
      "cantidad_fisica": 0.0
    }
  ],
  "total_declarado": 0.0,
  "total_efectivo_declarado": 0.0,
  "total_qr_declarado": 0.0,
  "gastos_o_vales": [
    {
      "concepto": "descripción del gasto (ej: pago personal, hielo, taxi, etc.)",
      "monto": 0.0
    }
  ],
  "alertas_visuales": [
    "observación relevante como tachones, números ilegibles, o frases como 'productos demás', 'vale cliente', etc."
  ]
}
PROMPT;

        $body = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt],
                        [
                            'inline_data' => [
                                'mime_type' => $mimeType,
                                'data' => $imgData
                            ]
                        ]
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature' => 0.1,
                'responseMimeType' => 'application/json'
            ]
        ];

        $models = [$this->model, 'gemini-3.5-flash-lite', 'gemini-flash-latest'];
        $response = null;

        foreach ($models as $m) {
            $url = "https://generativelanguage.googleapis.com/v1beta/models/{$m}:generateContent?key=" . $this->apiKey;
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            $resp = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode === 200) {
                $response = $resp;
                break;
            }
        }

        if (!$response) return null;

        $json = json_decode($response, true);
        $text = $json['candidates'][0]['content']['parts'][0]['text'] ?? null;
        if (!$text) return null;

        // Limpiar posibles bloques ```json
        $text = trim($text);
        if (strpos($text, '```') === 0) {
            $text = preg_replace('/^```(?:json)?\s*/i', '', $text);
            $text = preg_replace('/\s*```$/', '', $text);
        }

        return json_decode($text, true);
    }

    public function normalizarNombreProducto($nombre) {
        $n = strtoupper(trim($nombre));
        $n = str_replace(['Á','É','Í','Ó','Ú','Ñ'], ['A','E','I','O','U','N'], $n);
        $n = preg_replace('/[^A-Z0-9]/', '', $n);

        if (strpos($n, 'GROSO') !== false || strpos($n, 'GROSSO') !== false) return 'GROSSO';
        if (strpos($n, 'PACENA') !== false) return 'PACENA';
        if (strpos($n, 'POPULAR') !== false) return 'SODAPOPULAR';
        if (strpos($n, 'SODA2') !== false) return 'SODADE2LT';
        if (strpos($n, 'AGUA2') !== false) return 'AGUADE2L';
        if (strpos($n, 'POWER') !== false) return 'POWERGRANDE';
        if (strpos($n, 'PAPA') !== false) return 'PAPACHICA';
        if (strpos($n, 'MANI') !== false) return 'MANI';
        if (strpos($n, 'HUARI') !== false) return 'HUARI';
        if (strpos($n, 'COMBOAMSTEL') !== false) return 'COMBOAMSTEL';
        if (strpos($n, 'AMSTEL') !== false) return 'AMSTEL';
        return $n;
    }

    /**
     * Cruza lo extraído del cuaderno manuscrito contra las ventas registradas en el POS
     */
    public function cruzarCuadernoVsPos($codarqueo, $extraccionIA) {
        if (!$codarqueo || empty($extraccionIA['productos_anotados'])) {
            return [
                'coincidencias' => [],
                'discrepancias' => [],
                'resumen' => 'Sin datos de cuaderno para cruzar.'
            ];
        }

        // Obtener ventas reales registradas en el sistema para este arqueo agrupadas por nombre normalizado
        $sql = "SELECT dv.producto, SUM(dv.cantventa) as cant_pos, SUM(dv.valortotal) as total_pos
                FROM ventas v
                JOIN detalleventas dv ON v.codventa = dv.codventa
                WHERE v.codarqueo = :codarqueo
                GROUP BY dv.producto";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute([':codarqueo' => $codarqueo]);
        
        $ventasPos = [];
        $ventasPosNombres = [];
        while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $normKey = $this->normalizarNombreProducto($r['producto']);
            if (!isset($ventasPos[$normKey])) {
                $ventasPos[$normKey] = 0;
                $ventasPosNombres[$normKey] = $r['producto'];
            }
            $ventasPos[$normKey] += floatval($r['cant_pos']);
        }

        // Agrupar los productos del cuaderno manuscrito (que pueden estar en varias mesas)
        $cuadernoAgrupado = [];
        $cuadernoNombres = [];
        foreach ($extraccionIA['productos_anotados'] as $it) {
            $normKey = $this->normalizarNombreProducto($it['producto'] ?? '');
            if (empty($normKey)) continue;
            if (!isset($cuadernoAgrupado[$normKey])) {
                $cuadernoAgrupado[$normKey] = 0;
                $cuadernoNombres[$normKey] = $it['producto'];
            }
            $cuadernoAgrupado[$normKey] += floatval($it['cantidad'] ?? 0);
        }

        $coincidencias = [];
        $discrepancias = [];

        foreach ($cuadernoAgrupado as $normKey => $cantCuaderno) {
            $nomProd = $cuadernoNombres[$normKey] ?? $normKey;
            if (isset($ventasPos[$normKey])) {
                $cantPos = $ventasPos[$normKey];
                $diff = $cantCuaderno - $cantPos;
                if (abs($diff) < 0.01) {
                    $coincidencias[] = "{$nomProd}: {$cantCuaderno} u. (Cuaderno y POS coinciden exacto)";
                } else {
                    $discrepancias[] = "{$nomProd}: {$cantCuaderno} u. en cuaderno vs {$cantPos} u. en POS (" . ($diff > 0 ? "+{$diff} sin facturar en sistema" : "{$diff} facturado de más en sistema") . ")";
                }
            } else {
                $discrepancias[] = "{$nomProd}: {$cantCuaderno} u. anotadas en cuaderno pero NO figuran en ventas del POS.";
            }
        }

        return [
            'coincidencias' => $coincidencias,
            'discrepancias' => $discrepancias,
            'cuadrado' => empty($discrepancias)
        ];
    }

    /**
     * Cruza el conteo físico de la foto contra el stock teórico en el sistema
     */
    public function cruzarInventarioVsSistema($codsucursal, $extraccionIA) {
        if (!$codsucursal || empty($extraccionIA['stock_fisico_contado'])) {
            return [
                'coincidencias' => [],
                'discrepancias' => [],
                'cuadrado' => true
            ];
        }

        // Obtener stock actual de la sucursal
        $sql = "SELECT UPPER(TRIM(producto)) as prod_nom, existencia FROM productos WHERE codsucursal = :codsucursal";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute([':codsucursal' => $codsucursal]);
        $stockSistema = [];
        while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $stockSistema[$r['prod_nom']] = floatval($r['existencia']);
        }

        $coincidencias = [];
        $discrepancias = [];

        foreach ($extraccionIA['stock_fisico_contado'] as $stk) {
            $prod = strtoupper(trim($stk['producto'] ?? ''));
            $cantFisica = floatval($stk['cantidad_fisica'] ?? 0);
            if (empty($prod)) continue;

            $encontrado = false;
            foreach ($stockSistema as $nomPos => $cantPos) {
                if (strpos($nomPos, $prod) !== false || strpos($prod, $nomPos) !== false) {
                    $encontrado = true;
                    $diff = $cantFisica - $cantPos;
                    if (abs($diff) < 0.01) {
                        $coincidencias[] = "{$prod}: {$cantFisica} u. (Físico y Sistema coinciden)";
                    } else {
                        $discrepancias[] = "{$prod}: {$cantFisica} u. físicas en foto vs {$cantPos} u. en sistema (Diferencia: " . ($diff > 0 ? "+{$diff} sobrante físico" : "{$diff} faltante físico") . ")";
                    }
                    break;
                }
            }
        }

        return [
            'coincidencias' => $coincidencias,
            'discrepancias' => $discrepancias,
            'cuadrado' => empty($discrepancias)
        ];
    }

    /**
     * Evalúa si la hoja de cuadre manual cuadra con el POS y detecta gastos/egresos
     */
    public function evaluarCuadreManualVsPos($codarqueo, $extraccionIA, $totalRecaudadoPos, $efectivoPos = 0, $qrPos = 0) {
        if (empty($extraccionIA)) {
            return [
                'tiene_cuadre' => false,
                'resumen_corto' => '⏳ Sin foto de cuadre recibida',
                'linea_gastos' => ''
            ];
        }

        // 1. Extraer gastos y salidas anotadas por el cajero en la hoja manual
        $gastos = $extraccionIA['gastos_o_vales'] ?? $extraccionIA['gastos_o_salidas'] ?? [];
        $totalGastosHoja = 0.0;
        $conceptosGastos = [];
        foreach ($gastos as $g) {
            $m = floatval($g['monto'] ?? 0);
            if ($m > 0) {
                $totalGastosHoja += $m;
                $conc = trim($g['concepto'] ?? 'Gasto vario');
                $conceptosGastos[] = "{$conc} Bs. " . number_format($m, 0);
            }
        }

        // 2. Verificar si en el sistema POS se registraron esos egresos
        $totalGastosPos = 0.0;
        if ($codarqueo) {
            $sqlMov = "SELECT SUM(montomovimiento) as tot_mov FROM movimientoscajas WHERE codarqueo = :codarqueo AND tipomovimiento = 'EGRESO'";
            $stmtMov = $this->dbh->prepare($sqlMov);
            $stmtMov->execute([':codarqueo' => $codarqueo]);
            $rMov = $stmtMov->fetch(PDO::FETCH_ASSOC);
            $totalGastosPos = floatval($rMov['tot_mov'] ?? 0);

            if ($totalGastosPos == 0) {
                $sqlArq = "SELECT egresos FROM arqueocaja WHERE codarqueo = :codarqueo";
                $stmtArq = $this->dbh->prepare($sqlArq);
                $stmtArq->execute([':codarqueo' => $codarqueo]);
                $rArq = $stmtArq->fetch(PDO::FETCH_ASSOC);
                $totalGastosPos = floatval($rArq['egresos'] ?? 0);
            }
        }

        // 3. Evaluar cruce de dinero declarado en la hoja
        $totalDeclarado = floatval($extraccionIA['total_declarado'] ?? 0);
        if ($totalDeclarado == 0) {
            $totalDeclarado = floatval($extraccionIA['total_efectivo_declarado'] ?? 0) + floatval($extraccionIA['total_qr_declarado'] ?? 0);
        }

        $cuadraDinero = true;
        $difDinero = 0.0;
        if ($totalDeclarado > 0) {
            $difDinero = round($totalDeclarado - $totalRecaudadoPos, 2);
            $cuadraDinero = (abs($difDinero) <= 5.0); // Tolerancia mínima de 5 Bs
        }

        // 4. Evaluar cruce de productos si están anotados
        $cruceProds = $this->cruzarCuadernoVsPos($codarqueo, $extraccionIA);
        $cuadranProductos = $cruceProds['cuadrado'] ?? true;

        // 5. Redacción del estado de Cuadre Manual
        $cuadraTodo = $cuadraDinero && $cuadranProductos;
        $estadoCuadre = "";
        if ($cuadraTodo) {
            $estadoCuadre = "Cuadra con el sistema ✅";
        } else {
            if (!$cuadraDinero && abs($difDinero) > 0) {
                $estadoCuadre = "⚠️ Diferencia de Bs. " . number_format(abs($difDinero), 2) . " vs POS";
            } elseif (!$cuadranProductos) {
                $cantDisc = count($cruceProds['discrepancias'] ?? []);
                $estadoCuadre = "⚠️ {$cantDisc} productos con diferencia vs POS";
            } else {
                $estadoCuadre = "⚠️ Revisar diferencias con el sistema";
            }
        }

        // 6. Redacción clara y corta de Gastos en Hoja
        $lineaGastos = "";
        if ($totalGastosHoja > 0) {
            $descG = implode(', ', array_slice($conceptosGastos, 0, 3));
            if ($totalGastosPos > 0 && abs($totalGastosHoja - $totalGastosPos) <= 5) {
                $lineaGastos = "Bs. " . number_format($totalGastosHoja, 2) . " ({$descG}) - Registrado en POS ✅";
            } else {
                $lineaGastos = "⚠️ Bs. " . number_format($totalGastosHoja, 2) . " ({$descG}) - NO registrado en POS";
            }
        } else {
            $lineaGastos = "Sin gastos anotados";
        }

        return [
            'tiene_cuadre' => true,
            'cuadra_todo' => $cuadraTodo,
            'estado_cuadre' => $estadoCuadre,
            'hubo_gastos' => ($totalGastosHoja > 0),
            'linea_gastos' => $lineaGastos,
            'total_gastos_hoja' => $totalGastosHoja,
            'cruce_cuaderno' => $cruceProds
        ];
    }
}
