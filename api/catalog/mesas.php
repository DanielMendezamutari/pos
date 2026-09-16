<?php
require_once __DIR__ . '/../api_bootstrap.php';

// Accept branch from authenticated token or query param
$codsucursal = 0;
$token = SimpleJWT::getBearerToken();
if ($token) {
    $payload = SimpleJWT::decode($token);
    if ($payload && !empty($payload['codsucursal'])) {
        $codsucursal = (int)$payload['codsucursal'];
    }
}

if (empty($codsucursal) && !empty($_GET['codsucursal'])) {
    $codsucursal = (int)$_GET['codsucursal'];
}

if (empty($codsucursal)) {
    $auth = requireAuth();
    $codsucursal = (int)$auth['codsucursal'];
}

$service = new ComandaService();
$rawMesas = $service->listarMesas($codsucursal, true);

$mesas = [];
foreach ($rawMesas as $m) {
    $nom = trim($m['nromesa'] ?? $m['nommesa'] ?? 'Mesa');
    $mesas[] = [
        'id' => (int)$m['codmesa'],
        'codmesa' => (int)$m['codmesa'],
        'nombre' => $nom,
        'nommesa' => $nom,
        'nromesa' => $nom,
        'codsucursal' => (int)$m['codsucursal'],
        'estado' => (int)$m['estado'],
        'orden' => (int)($m['orden'] ?? 0)
    ];
}

jsonResponse([
    'success' => true,
    'codsucursal' => $codsucursal,
    'total' => count($mesas),
    'mesas' => $mesas
]);
