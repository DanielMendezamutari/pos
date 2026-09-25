<?php
/**
 * Endpoint de Sincronización Segura de Fotos de Auditoría
 * Permite descargar empaquetadas las fotos recibidas por el bot de WhatsApp
 * desde el hosting hacia la estación local de auditoría.
 */

define('AUDITORIA_SYNC_SECRET', 'JOKER_AUDITORIA_SYNC_KEY_2026_9xPqLz');
$baseDir = dirname(__DIR__) . '/auditoria_fotos';

$token = $_REQUEST['token'] ?? '';
$authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
if (preg_match('/Bearer\s+(.*)$/i', $authHeader, $matches)) {
    $token = $matches[1];
}

if ($token !== AUDITORIA_SYNC_SECRET) {
    http_response_code(403);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['error' => 'Acceso no autorizado. Token inválido.'], JSON_UNESCAPED_UNICODE);
    exit;
}

$accion = $_GET['accion'] ?? 'descargar';
$fecha = $_GET['fecha'] ?? date('Y-m-d');

if ($accion === 'status') {
    header('Content-Type: application/json; charset=utf-8');
    $botDir = dirname(__DIR__) . '/whatsapp_bot';
    $authDir = $botDir . '/auth_info_baileys';
    $qrPath = $botDir . '/qr.html';
    $logPath = $botDir . '/bot_salida.log';
    $watchdogLog = $botDir . '/bot_watchdog.log';

    $pid = trim(@shell_exec('pgrep -f "node bot.js" | head -n 1') ?? '');
    $tieneSesion = is_dir($authDir) && count(glob($authDir . '/*')) > 2;
    $tieneQr = file_exists($qrPath);

    $ultimasLineas = [];
    if (file_exists($logPath)) {
        $lineas = @file($logPath);
        if ($lineas) $ultimasLineas = array_map('trim', array_slice($lineas, -15));
    }

    echo json_encode([
        'bot_corriendo' => !empty($pid),
        'pid' => $pid ?: null,
        'sesion_vinculada' => $tieneSesion,
        'qr_disponible' => $tieneQr,
        'url_qr' => 'https://joker.ribersoft.com/whatsapp_bot/qr.html',
        'directorio_bot' => $botDir,
        'fotos_dir_existe' => is_dir($baseDir),
        'ultimas_lineas_log' => $ultimasLineas
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

// Validar formato de fecha (YYYY-MM-DD) para descargar
if ($accion === 'descargar' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) {
    http_response_code(400);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['error' => 'Formato de fecha inválido. Use YYYY-MM-DD.'], JSON_UNESCAPED_UNICODE);
    exit;
}

if ($accion === 'listar') {
    header('Content-Type: application/json; charset=utf-8');
    if (!is_dir($baseDir)) {
        echo json_encode(['fechas' => []]);
        exit;
    }

    $fechasDisponibles = [];
    $carpetas = scandir($baseDir);
    foreach ($carpetas as $f) {
        if ($f === '.' || $f === '..' || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $f)) continue;
        $rutaDia = $baseDir . '/' . $f;
        if (is_dir($rutaDia)) {
            $sucursales = [];
            $totalFotos = 0;
            $items = scandir($rutaDia);
            foreach ($items as $suc) {
                if ($suc === '.' || $suc === '..' || !is_dir($rutaDia . '/' . $suc)) continue;
                $archivos = glob($rutaDia . '/' . $suc . '/*.{jpg,jpeg,png,webp}', GLOB_BRACE);
                $cant = count($archivos);
                $totalFotos += $cant;
                $sucursales[$suc] = $cant;
            }
            $fechasDisponibles[] = [
                'fecha' => $f,
                'total_fotos' => $totalFotos,
                'sucursales' => $sucursales
            ];
        }
    }

    usort($fechasDisponibles, fn($a, $b) => strcmp($b['fecha'], $a['fecha']));
    echo json_encode(['fechas' => $fechasDisponibles], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

if ($accion === 'descargar') {
    $rutaDia = $baseDir . '/' . $fecha;
    if (!is_dir($rutaDia)) {
        http_response_code(404);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['error' => "No se encontraron fotos para la fecha: {$fecha}"], JSON_UNESCAPED_UNICODE);
        exit;
    }

    if (!class_exists('ZipArchive')) {
        http_response_code(500);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['error' => 'La extensión ZipArchive no está habilitada en el servidor.'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $zip = new ZipArchive();
    $zipTempFile = tempnam(sys_get_temp_dir(), 'auditoria_zip_');
    if ($zip->open($zipTempFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
        http_response_code(500);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['error' => 'No se pudo crear el archivo ZIP temporal.'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // Agregar todos los archivos recursivamente
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($rutaDia, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::LEAVES_ONLY
    );

    $archivosAgregados = 0;
    foreach ($files as $name => $file) {
        if (!$file->isDir()) {
            $filePath = $file->getRealPath();
            $relativePath = substr($filePath, strlen($rutaDia) + 1);
            $zip->addFile($filePath, $relativePath);
            $archivosAgregados++;
        }
    }
    $zip->close();

    if ($archivosAgregados === 0) {
        @unlink($zipTempFile);
        http_response_code(404);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['error' => "La carpeta del día {$fecha} existe pero está vacía."], JSON_UNESCAPED_UNICODE);
        exit;
    }

    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="auditoria_fotos_' . $fecha . '.zip"');
    header('Content-Length: ' . filesize($zipTempFile));
    header('Pragma: no-cache');
    header('Expires: 0');

    readfile($zipTempFile);
    @unlink($zipTempFile);
    exit;
}
