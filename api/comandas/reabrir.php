<?php
require_once __DIR__ . '/../api_bootstrap.php';

$input = getJsonInput();
$idcomanda = (int)($_GET['idcomanda'] ?? $input['idcomanda'] ?? 0);

if ($idcomanda <= 0) {
    jsonResponse(['success' => false, 'mensaje' => 'ID de comanda requerido y debe ser numérico'], 400);
}

$service = new ComandaService();
$res = $service->reabrirComanda($idcomanda);

jsonResponse($res);
