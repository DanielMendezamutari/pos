<?php
require_once __DIR__ . '/../api_bootstrap.php';

$service = new ComandaService();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $codsucursal = isset($_GET['sucursal']) ? (int)$_GET['sucursal'] : 0;
    if ($codsucursal <= 0) jsonResponse(['success' => false, 'mensaje' => 'Sucursal requerida'], 400);
    $mesas = $service->listarMesas($codsucursal, false);
    jsonResponse(['success' => true, 'mesas' => $mesas]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = getJsonInput();
    $accion = $input['accion'] ?? 'guardar';

    if ($accion === 'estado') {
        $codmesa = $input['codmesa'] ?? 0;
        $estado = $input['estado'] ?? 1;
        $res = $service->cambiarEstadoMesa($codmesa, $estado);
        jsonResponse($res);
    } else {
        $codmesa = $input['codmesa'] ?? null;
        $nromesa = $input['nromesa'] ?? '';
        $codsucursal = $input['codsucursal'] ?? 0;
        $estado = $input['estado'] ?? 1;
        $orden = $input['orden'] ?? 0;
        $res = $service->guardarMesa($codmesa, $nromesa, $codsucursal, $estado, $orden);
        jsonResponse($res);
    }
}
