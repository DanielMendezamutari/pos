<?php
require_once __DIR__ . '/../api_bootstrap.php';

$auth = requireAuth();

$service = new ComandaService();
$res = $service->historialMesera($auth['idmesera'], $auth['codsucursal']);

jsonResponse(array_merge(['success' => true], $res));
