<?php

require_once __DIR__ . '/../../../config/db_connect.php';
require_once __DIR__ . '/../../Models/tools/any_table.php';


$db = Database::connect();
$etat = new AnyTable($db, 'etats', 'id', $id);     // $_GET['id']

$row = $etat->fetchOne();

if ($row) {
    echo json_encode(value: ['etat' => $row]);
} else {
    echo json_encode(['message' => "No records found!"]);
}



