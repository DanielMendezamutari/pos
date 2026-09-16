<?php
require_once __DIR__ . '/../api_bootstrap.php';

$codsucursal = isset($_GET['sucursal']) ? (int)$_GET['sucursal'] : 0;
if ($codsucursal <= 0) {
    jsonResponse(['success' => false, 'mensaje' => 'Sucursal requerida'], 400);
}

$service = new ComandaService();
$pendientes = $service->listarComandasPendientes($codsucursal);

jsonResponse([
    'success' => true,
    'total_pendientes' => count($pendientes),
    'comandas' => $pendientes
]);
