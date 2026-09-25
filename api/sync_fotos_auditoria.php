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

    $pid = trim(@shell_exec('pgrep -f "bot.js" | head -n 1') ?? '');
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

if ($accion === 'fotos_recientes') {
    header('Content-Type: application/json; charset=utf-8');
    $archivos = [];
    if (is_dir($baseDir)) {
        $iter = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($baseDir));
        foreach ($iter as $file) {
            if ($file->isFile() && preg_match('/\.(jpg|jpeg|png|webp)$/i', $file->getFilename())) {
                $archivos[] = [
                    'ruta' => str_replace('\\', '/', str_replace($baseDir . DIRECTORY_SEPARATOR, '', $file->getPathname())),
                    'nombre' => $file->getFilename(),
                    'tamano' => $file->getSize(),
                    'modificado' => date('Y-m-d H:i:s', $file->getMTime())
                ];
            }
        }
        usort($archivos, fn($a, $b) => strcmp($b['modificado'], $a['modificado']));
    }
    echo json_encode(['total' => count($archivos), 'archivos' => array_slice($archivos, 0, 30)], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

if ($accion === 'actualizar_git') {
    header('Content-Type: application/json; charset=utf-8');
    $repoDir = dirname(__DIR__);
    $salida = [];
    $ret = 0;
    exec("cd " . escapeshellarg($repoDir) . " && git checkout -- whatsapp_bot/verificar_y_levantar.sh && git pull origin main 2>&1", $salida, $ret);
    
    $reiniciarBot = $_REQUEST['reiniciar_bot'] ?? '1';
    if ($reiniciarBot === '1') {
        @exec("pkill -9 -f 'bot.js' 2>&1");
        $sh = $repoDir . '/whatsapp_bot/verificar_y_levantar.sh';
        if (file_exists($sh)) {
            @chmod($sh, 0755);
            @exec("bash " . escapeshellarg($sh) . " >/dev/null 2>&1 &");
        }
    }

    echo json_encode([
        'status' => ($ret === 0 ? 'success' : 'error'),
        'git_salida' => $salida,
        'codigo_retorno' => $ret,
        'bot_reiniciado' => ($reiniciarBot === '1')
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

if ($accion === 'guardar_gemini_key') {
    header('Content-Type: application/json; charset=utf-8');
    $k = $_POST['key'] ?? $_GET['key'] ?? '';
    if (!empty($k)) {
        file_put_contents(dirname(__DIR__) . '/gemini_key.txt', trim($k));
        echo json_encode(['status' => 'guardado']);
        exit;
    }
    echo json_encode(['error' => 'Falta key']);
    exit;
}

if ($accion === 'ejecutar_cron_auditoria') {
    header('Content-Type: application/json; charset=utf-8');
    $script = dirname(__DIR__) . '/scripts/cron_auditoria_turno_noche_1000.php';
    $salida = [];
    $ret = 0;
    exec("php " . escapeshellarg($script) . " 2>&1", $salida, $ret);
    echo json_encode([
        'status' => ($ret === 0 ? 'success' : 'error'),
        'salida' => $salida,
        'codigo' => $ret
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

if ($accion === 'encolar_envio') {
    header('Content-Type: application/json; charset=utf-8');
    $colaDir = dirname(__DIR__) . '/whatsapp_bot/cola_envios';
    if (!is_dir($colaDir)) @mkdir($colaDir, 0777, true);

    $texto = $_POST['texto'] ?? $_GET['texto'] ?? '';
    $pdfPath = $_POST['pdfPath'] ?? $_GET['pdfPath'] ?? '';
    $caption = $_POST['caption'] ?? $_GET['caption'] ?? '';
    $jid = $_POST['jid'] ?? $_GET['jid'] ?? '';

    // Manejar subida de archivo PDF vía multipart/form-data
    if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] === UPLOAD_ERR_OK) {
        $adjuntosDir = $colaDir . '/adjuntos';
        if (!is_dir($adjuntosDir)) @mkdir($adjuntosDir, 0777, true);
        $nombreDestino = time() . '_' . preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', $_FILES['pdf']['name']);
        $destinoFinal = $adjuntosDir . '/' . $nombreDestino;
        if (move_uploaded_file($_FILES['pdf']['tmp_name'], $destinoFinal)) {
            $pdfPath = $destinoFinal;
        }
    } elseif (!empty($_POST['base64_pdf'])) {
        $adjuntosDir = $colaDir . '/adjuntos';
        if (!is_dir($adjuntosDir)) @mkdir($adjuntosDir, 0777, true);
        $nombreDoc = $_POST['pdf_nombre'] ?? ('informe_' . date('Ymd_His') . '.pdf');
        $destinoFinal = $adjuntosDir . '/' . time() . '_' . $nombreDoc;
        $pdfData = base64_decode($_POST['base64_pdf']);
        if ($pdfData !== false) {
            file_put_contents($destinoFinal, $pdfData);
            $pdfPath = $destinoFinal;
        }
    }

    $datos = [
        'texto' => $texto,
        'pdfPath' => $pdfPath,
        'caption' => $caption,
        'jid' => $jid,
        'creado' => date('Y-m-d H:i:s')
    ];

    $archivoId = 'envio_' . time() . '_' . rand(100, 999) . '.json';
    file_put_contents($colaDir . '/' . $archivoId, json_encode($datos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    echo json_encode([
        'status' => 'encolado',
        'archivo' => $archivoId,
        'tiene_pdf' => !empty($pdfPath),
        'mensaje' => 'Envío encolado con éxito para WhatsApp'
    ]);
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
