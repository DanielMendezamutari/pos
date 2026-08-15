<?php
require 'class/class.php';

class TestLogin extends Login {
    public function db() { return $this->dbh; }
}

$tra = new TestLogin();

// Simular GET que envia JS
$origenEnc = encrypt(1);
$destinoEnc = encrypt(2);

echo "origen encriptado: " . $origenEnc . "\n";
echo "destino encriptado: " . $destinoEnc . "\n";

// Desencriptar
$origen = decrypt($origenEnc);
$destino = decrypt($destinoEnc);
echo "origen: " . $origen . "\n";
echo "destino: " . $destino . "\n";

// Listar productos origen
echo "\nListando productos sucursal {$origen}...\n";
$reg = $tra->ListarProductosSucursal($origen);
if ($reg == "") {
    echo "(sin productos)\n";
} else {
    echo "Total productos: " . sizeof($reg) . "\n";
    $ids = [];
    for ($i = 0; $i < sizeof($reg); $i++) {
        if (!$tra->ProductoExisteSucursal($reg[$i]['codproducto'], $destino)) {
            $ids[] = encrypt($reg[$i]['idproducto']);
        }
    }
    echo "IDs a copiar: " . sizeof($ids) . "\n";
    echo "JSON:\n" . json_encode(["status" => "ok", "total" => sizeof($ids), "ids" => $ids]) . "\n";
}
