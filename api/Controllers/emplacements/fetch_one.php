<?php

require_once __DIR__ . '/../../../config/db_connect.php';
require_once __DIR__ . '/../../Models/tools/any_table.php';


$db = Database::connect();
$emplacement = new AnyTable($db, 'emplacements', 'id', $id);     // $_GET['id']

$row = $emplacement->fetchOne();

if ($row) {
    echo json_encode(value: ['emplacement' => $row]);
} else {
    echo json_encode(['message' => "No records found!"]);
}



