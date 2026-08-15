<?php
require 'class/class.php';
$l = new Login();
$u = $l->ListarUsuarios();
foreach ($u as $x) {
    echo $x['usuario'] . ' | ' . $x['nivel'] . "\n";
}
