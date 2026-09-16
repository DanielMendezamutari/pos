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
$rawProductos = $service->listarProductosComanda($codsucursal);

$productos = [];
$categorias = [];
foreach ($rawProductos as $p) {
    $cat = strtoupper(trim($p['categoria'] ?? 'GENERAL'));
    if (!in_array($cat, $categorias)) {
        $categorias[] = $cat;
    }

    $nombreProd = trim($p['producto'] ?? '');
    $productos[] = [
        'id' => (int)$p['idproducto'],
        'idproducto' => (int)$p['idproducto'],
        'nombre' => $nombreProd,
        'producto' => $nombreProd,
        'precio' => floatval($p['precio']),
        'stock' => floatval($p['existencia']),
        'existencia' => floatval($p['existencia']),
        'tipo' => strtolower($p['tipoproducto'] ?? 'producto'),
        'tipoproducto' => $p['tipoproducto'] ?? 'PRODUCTO',
        'categoria' => $cat,
        'codigo' => $p['codproducto'] ?? '',
        'codproducto' => $p['codproducto'] ?? ''
    ];
}
sort($categorias);
array_unshift($categorias, 'TODOS');

jsonResponse([
    'success' => true,
    'codsucursal' => $codsucursal,
    'total' => count($productos),
    'categorias' => $categorias,
    'productos' => $productos
]);
