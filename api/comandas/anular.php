<?php
require_once __DIR__ . '/../api_bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['success' => false, 'mensaje' => 'Método no permitido'], 405);
}

$input = getJsonInput();
$idcomanda = (int)($input['idcomanda'] ?? 0);
$motivo = trim($input['motivo'] ?? 'Anulado en caja');

if (empty($idcomanda)) {
    jsonResponse(['success' => false, 'mensaje' => 'ID de comanda requerido'], 400);
}

$service = new ComandaService();
$res = $service->anularComanda($idcomanda, $motivo);

jsonResponse($res);
