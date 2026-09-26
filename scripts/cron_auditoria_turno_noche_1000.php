<?php
/**
 * Cron Job: Auditoría Cierre Turno Noche + Apertura Turno Tarde (10:00 AM)
 * Despacha 1 mensaje completo + 1 PDF oficial por cada sucursal (4 envíos independientes).
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
echo "☀️ AUDITORÍA AUTOMÁTICA TURNO NOCHE (1 MENSAJE POR SUCURSAL)\n";
echo "📅 Fecha: {$fechaHoy} | Hora: " . date('H:i') . "\n";
echo "========================================================\n\n";

$num = 1;
foreach ($sucursales as $suc) {
    $cod = $suc['codsucursal'];
    $nombre = $suc['nomsucursal'];
    $slug = strtolower(preg_replace('/[^a-zA-Z0-9]/', '_', $nombre));

    // 1. Generar ÚNICO PDF de Auditoría de 1 página para la sucursal
    $pdfCuadrePath = $dirSalida . "/{$slug}_auditoria_noche.pdf";
    $service->generarPdfCuadre($suc, 'Noche', $fechaHoy, $pdfCuadrePath);
    echo "✅ [{$nombre}] Generado PDF de auditoría: " . basename($pdfCuadrePath) . "\n";

    // 2. Generar Mensaje Completo e Individual para esta sucursal (Cruce, Caja, Stock, Faltantes/Sobrantes)
    $textoMensaje = $service->generarMensajeAuditoriaSucursal($suc, 'Noche', $fechaHoy, $fechaIso);

    // 3. Encolar paquete de esta sucursal (Texto + PDF)
    $prefijo = str_pad($num, 2, '0', STR_PAD_LEFT);
    $datosEnvio = [
        'sucursal' => $nombre,
        'codsucursal' => $cod,
        'turno' => 'Noche',
        'texto' => $textoMensaje,
        'pdfPath' => realpath($pdfCuadrePath),
        'caption' => "📄 {$nombre} - Auditoría y Control de Mermas Turno Noche ({$fechaHoy})",
        'creado' => date('Y-m-d H:i:s')
    ];

    $archivoCola = $colaLocal . "/envio_{$prefijo}_{$slug}_" . time() . ".json";
    file_put_contents($archivoCola, json_encode($datosEnvio, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    echo "📤 [{$nombre}] Encolado mensaje individual y PDF ({$archivoCola})\n";
    $num++;
}

echo "\n🚀 Los 4 paquetes de auditoría (1 mensaje completo + 1 PDF por sucursal) han sido encolados exitosamente.\n";
echo "El bot despachará individualmente cada casa al grupo 'Reportes Auditoría Joker'.\n";
