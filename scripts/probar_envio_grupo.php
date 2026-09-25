<?php
/**
 * Script de Prueba de Envío de Reporte a WhatsApp
 * Envía un resumen ejecutivo y el PDF de auditoría al grupo "Reportes Auditoría Joker"
 */

$pdfLocal = dirname(__DIR__) . '/informe_auditoria_joker_ultra_con_fotos.pdf';
if (!file_exists($pdfLocal)) {
    // Si no existe con fotos, buscar el informe normal
    $pdfLocal = dirname(__DIR__) . '/informe_auditoria_sucursal_ultra.pdf';
}

$textoMensaje = "🃏 *REPORTE DE AUDITORÍA - JOKER ULTRA* 🃏\n";
$textoMensaje .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
$textoMensaje .= "📅 *Período:* 23 al 24 de Septiembre 2026\n";
$textoMensaje .= "🕒 *Generado:* " . date('d/m/Y H:i') . "\n";
$textoMensaje .= "👤 *Control:* Auditoría Interna Joker\n\n";

$textoMensaje .= "💰 *1. CONCILIACIÓN DE CAJAS (CIERRE DIARIO):*\n";
$textoMensaje .= "  • *Turno Tarde (Arqueo #307):*\n";
$textoMensaje .= "    - Efectivo: Bs. 1,460.00 | QR: Bs. 40.00\n";
$textoMensaje .= "    - Estado: *CUADRADO EXACTO* ✅\n";
$textoMensaje .= "  • *Turno Noche (Arqueo #311):*\n";
$textoMensaje .= "    - Efectivo Físico: Bs. 1,984.00 | QR: Bs. 920.00\n";
$textoMensaje .= "    - Nota: Error de tipeo en sistema (1.98 vs 1,984) respaldado con ticket térmico.\n";
$textoMensaje .= "    - Estado: *CUADRADO CON FOTO DE TICKET* ✅\n\n";

$textoMensaje .= "📦 *2. CONTROL DE STOCK Y RELEVO FÍSICO:*\n";
$textoMensaje .= "  • *Mermas detectadas al turno noche:*\n";
$textoMensaje .= "    - Amstel (AM467): -5 botellas (Bs. 75.00 costo)\n";
$textoMensaje .= "    - Corona (CRNQ): -1 botella (Bs. 12.00 costo)\n";
$textoMensaje .= "    - Paceña (PA13): -1 botella (Bs. 16.00 costo)\n";
$textoMensaje .= "    - Burguesa Gold (2115): -1 botella (Bs. 15.00 costo)\n";
$textoMensaje .= "    - Golosinas varias: -10 unidades (Bs. 22.00 costo)\n";
$textoMensaje .= "  • *Total retención sugerida al cajero noche:* *Bs. 140.00*\n\n";

$textoMensaje .= "📋 *3. OBSERVACIONES GENERALES:*\n";
$textoMensaje .= "  • Recepción física de compra BG64 reflejada en conteo de sodas (+29 2L, +23 Pop).\n";
$textoMensaje .= "  • Se adjunta el informe pericial completo con evidencias fotográficas.\n";
$textoMensaje .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
$textoMensaje .= "🤖 _Mensaje automatizado generado por el bot de auditoría Joker._";

echo "========================================================\n";
echo "📤 PROBANDO ENVÍO DE REPORTE AL GRUPO DE WHATSAPP\n";
echo "========================================================\n\n";

// Si estamos en el servidor directamente (existe whatsapp_bot/cola_envios)
$colaLocal = dirname(__DIR__) . '/whatsapp_bot/cola_envios';
if (is_dir(dirname(__DIR__) . '/whatsapp_bot')) {
    if (!is_dir($colaLocal)) @mkdir($colaLocal, 0777, true);
    
    $datos = [
        'texto' => $textoMensaje,
        'pdfPath' => file_exists($pdfLocal) ? realpath($pdfLocal) : null,
        'caption' => '📄 Informe Pericial de Auditoría - Joker Ultra (Con Evidencias)',
        'creado' => date('Y-m-d H:i:s')
    ];
    
    $archivoId = 'envio_' . time() . '_' . rand(100, 999) . '.json';
    file_put_contents($colaLocal . '/' . $archivoId, json_encode($datos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    echo "✅ Archivo encolado localmente en: {$colaLocal}/{$archivoId}\n";
    echo "⏳ El bot de WhatsApp procesará y despachará este envío al grupo en los próximos segundos.\n";
}

// También enviar vía API al servidor remoto de joker.ribersoft.com
$apiUrl = 'https://joker.ribersoft.com/api/sync_fotos_auditoria.php?accion=encolar_envio&token=JOKER_AUDITORIA_SYNC_KEY_2026_9xPqLz';

echo "\n🌐 Enviando también mediante API a joker.ribersoft.com...\n";

$curl = curl_init();
$postData = [
    'texto' => $textoMensaje,
    'caption' => '📄 Informe Pericial de Auditoría - Joker Ultra (Con Evidencias)'
];

if (file_exists($pdfLocal)) {
    $postData['pdf'] = new CURLFile($pdfLocal, 'application/pdf', basename($pdfLocal));
}

curl_setopt_array($curl, [
    CURLOPT_URL => $apiUrl,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $postData,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_SSL_VERIFYPEER => false
]);

$respuesta = curl_exec($curl);
$error = curl_error($curl);
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

if ($error) {
    echo "⚠️ Error cURL API: $error\n";
} else {
    echo "📡 Respuesta API (HTTP $httpCode):\n$respuesta\n";
}

echo "\n🏁 Prueba finalizada.\n";
