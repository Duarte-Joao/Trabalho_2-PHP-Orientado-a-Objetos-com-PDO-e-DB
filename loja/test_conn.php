<?php
require 'database/db.class.php';
$db = new db('funcionario');
try {
    $c = $db->conn();
    if ($c) echo "Conectado OK ao banco lojachape";
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
