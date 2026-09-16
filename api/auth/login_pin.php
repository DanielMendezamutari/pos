<?php
require_once __DIR__ . '/../api_bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['success' => false, 'mensaje' => 'Método no permitido'], 405);
}

$input = getJsonInput();
$pin = $input['pin'] ?? '';
$codsucursal = $input['codsucursal'] ?? 0;

if (empty($pin) || empty($codsucursal)) {
    jsonResponse(['success' => false, 'mensaje' => 'PIN y sucursal requeridos.'], 400);
}

$service = new ComandaService();
$result = $service->validarPinMesera($pin, $codsucursal);

if (!$result['success']) {
    jsonResponse($result, 401);
}

// Generar JWT
$payload = [
    'idmesera' => $result['mesera']['id'],
    'nombre' => $result['mesera']['nombre'],
    'codsucursal' => $result['mesera']['codsucursal'],
    'codarqueo' => $result['arqueo']['codarqueo'],
    'iat' => time(),
    'exp' => time() + (3600 * 16) // 16 horas de turno
];

$token = SimpleJWT::encode($payload);

jsonResponse([
    'success' => true,
    'mensaje' => 'Bienvenida ' . $result['mesera']['nombre'],
    'token' => $token,
    'mesera' => $result['mesera'],
    'arqueo' => $result['arqueo']
]);
