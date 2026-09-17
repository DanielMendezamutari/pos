<?php
/**
 * Heartbeat / Keep-Alive de Sesión para el POS
 * Mantiene la sesión PHP activa mientras la cajera tenga la ventana abierta
 * y verifica si la sesión sigue siendo válida.
 */
session_start();
header('Content-Type: application/json; charset=utf-8');

if (isset($_SESSION['acceso']) && isset($_SESSION['codigo'])) {
    // Refrescar el timestamp de actividad para evitar que ExpiraSession() cierre la sesión
    $_SESSION['time'] = time();

    echo json_encode([
        'success' => true,
        'activo' => true,
        'usuario' => $_SESSION['usuario'] ?? '',
        'codsucursal' => $_SESSION['codsucursal'] ?? 0,
        'time' => $_SESSION['time']
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

echo json_encode([
    'success' => false,
    'activo' => false,
    'mensaje' => 'La sesión ha expirado o no está activa.'
], JSON_UNESCAPED_UNICODE);
exit;
