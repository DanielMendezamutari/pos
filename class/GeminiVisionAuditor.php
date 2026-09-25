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
  "total_efectivo_declarado": 0.0,
  "gastos_o_vales": [
    {
      "concepto": "descripción",
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
}
