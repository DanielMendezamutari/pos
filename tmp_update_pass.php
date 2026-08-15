<?php
require 'class/class.php';
class T extends Login { public function db() { return $this->dbh; } }
$l = new T();
$s = $l->db()->prepare("UPDATE usuarios SET password=? WHERE usuario=?");
$s->execute(array(password_hash('admin', PASSWORD_DEFAULT), 'ADMINGENERAL'));
echo 'filas: ' . $s->rowCount();
