<?php
/**
 * Bootstrap común para la API REST de Joker Comandas
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/jwt_helper.php';
require_once __DIR__ . '/../class/class.comandas.php';

function jsonResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}

function getJsonInput() {
    $input = file_get_contents('php://input');
    return json_decode($input, true) ?: [];
}

function requireAuth() {
    $token = SimpleJWT::getBearerToken();
    if (!$token) {
        jsonResponse(['success' => false, 'mensaje' => 'Token de autorización ausente o inválido.'], 401);
    }
    $payload = SimpleJWT::decode($token);
    if (!$payload || !isset($payload['idmesera'])) {
        jsonResponse(['success' => false, 'mensaje' => 'Token expirado o inválido.'], 401);
    }
    return $payload;
}
