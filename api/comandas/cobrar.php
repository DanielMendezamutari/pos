<?php
require_once __DIR__ . '/../api_bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['success' => false, 'mensaje' => 'Método no permitido'], 405);
}

$input = getJsonInput();
$idcomanda = $input['idcomanda'] ?? $input['ids'] ?? 0;
$codventa = $input['codventa'] ?? '';

if (empty($idcomanda)) {
    jsonResponse(['success' => false, 'mensaje' => 'ID de comanda requerido'], 400);
}

$service = new ComandaService();
$res = $service->cobrarComanda($idcomanda, $codventa);

jsonResponse($res);
