<?php
require_once __DIR__ . '/../api_bootstrap.php';

$service = new ComandaService();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $codsucursal = isset($_GET['sucursal']) ? (int)$_GET['sucursal'] : 0;
    if ($codsucursal <= 0) jsonResponse(['success' => false, 'mensaje' => 'Sucursal requerida'], 400);
    $meseras = $service->listarMeseras($codsucursal);
    jsonResponse(['success' => true, 'meseras' => $meseras]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = getJsonInput();
    $idmesera = $input['idmesera'] ?? null;
    $nombre = $input['nombre'] ?? '';
    $pin = $input['pin'] ?? '';
    $codsucursal = $input['codsucursal'] ?? 0;
    $estado = $input['estado'] ?? 1;

    $res = $service->guardarMesera($idmesera, $nombre, $pin, $codsucursal, $estado);
    jsonResponse($res);
}
