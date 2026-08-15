<?php
require 'class/class.php';
class T extends Login { public function db() { return $this->dbh; } }
$l = new T();
$s = $l->db()->query('DESCRIBE productos');
while ($r = $s->fetch(PDO::FETCH_ASSOC)) {
    echo $r['Field'] . ' ' . $r['Type'] . "\n";
}
