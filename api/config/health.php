<?php
require_once __DIR__ . '/../api_bootstrap.php';

$service = new ComandaService();

jsonResponse([
    'status' => 200,
    'success' => true,
    'app' => 'JOKER BILLAR & BAR - API COMANDAS',
    'sistema' => 'Ribersoft POS',
    'desarrollado_por' => 'Ing. Daniel Méndez Amutari',
    'servidor_tiempo' => date('Y-m-d H:i:s'),
    'estado' => 'ONLINE'
]);
