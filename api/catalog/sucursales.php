<?php
require_once __DIR__ . '/../api_bootstrap.php';

$db = new Db();
$reflector = new ReflectionClass('Db');
$prop = $reflector->getProperty('dbh');
$prop->setAccessible(true);
$dbh = $prop->getValue($db);

$stmt = $dbh->query("SELECT codsucursal, nomsucursal, cuitsucursal FROM sucursales ORDER BY codsucursal ASC");
$sucursales = $stmt->fetchAll(PDO::FETCH_ASSOC);

$service = new ComandaService();
$res = [];
foreach ($sucursales as $s) {
    $arq = $service->obtenerArqueoActivo($s['codsucursal']);
    $res[] = [
        'id' => (int)$s['codsucursal'],
        'codsucursal' => (int)$s['codsucursal'],
        'nombre' => trim($s['nomsucursal']),
        'nombresucursal' => trim($s['nomsucursal']),
        'caja_abierta' => ($arq !== null),
        'caja_actual' => $arq ? $arq['nomcaja'] : null,
        'cajero' => $arq ? $arq['nomcaja'] : null
    ];
}

jsonResponse(['success' => true, 'sucursales' => $res]);
