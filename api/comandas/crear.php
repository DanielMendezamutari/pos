<?php
require_once __DIR__ . '/../api_bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['success' => false, 'mensaje' => 'Método no permitido'], 405);
}

$auth = requireAuth();
$input = getJsonInput();

$codmesa = $input['codmesa'] ?? 0;
$nombre_mesa = trim($input['nombre_mesa'] ?? $input['mesa_nombre'] ?? 'Barra');
$metodo_pago = trim($input['metodo_pago'] ?? 'EFECTIVO');
$items = $input['items'] ?? [];

if (empty($items)) {
    jsonResponse(['success' => false, 'status' => 400, 'mensaje' => 'No hay productos en la comanda.'], 400);
}

$service = new ComandaService();
$res = $service->crearComanda(
    $auth['idmesera'],
    $codmesa,
    $nombre_mesa,
    $auth['codsucursal'],
    $items,
    $metodo_pago
);

if (!$res['success']) {
    jsonResponse($res, 400);
}

jsonResponse($res, 200);
