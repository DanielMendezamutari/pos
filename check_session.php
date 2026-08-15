<?php
require_once("class/class.php");
header('Content-Type: text/plain');
echo array_key_exists('acceso', $_SESSION) ? $_SESSION['acceso'] : 'no_session';
?>
