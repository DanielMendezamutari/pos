<?php
require 'class/class.php';
$origenEnc = encrypt(12341234);
$destinoEnc = encrypt(1);
echo 'origenEnc='.$origenEnc."\n";
echo 'destinoEnc='.$destinoEnc."\n";
echo 'origen='.decrypt($origenEnc)."\n";
echo 'destino='.decrypt($destinoEnc)."\n";
