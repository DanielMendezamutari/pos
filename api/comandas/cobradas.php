<?php
require_once __DIR__ . '/../api_bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    jsonResponse(['success' => false, 'mensaje' => 'Método no permitido'], 405);
}

$codsucursal = (int)($_GET['sucursal'] ?? 0);
if ($codsucursal <= 0) {
    jsonResponse(['success' => false, 'mensaje' => 'Sucursal requerida'], 400);
}

$service = new ComandaService();
$comandas = $service->listarComandasCobradas($codsucursal);

jsonResponse([
    'success' => true,
    'total_cobradas' => count($comandas),
    'comandas' => $comandas
]);
