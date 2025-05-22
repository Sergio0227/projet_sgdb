<?php

require_once __DIR__ . '/../../../config/db_connect.php';
require_once __DIR__ . '/../../Models/tools/any_table.php';


$db = Database::connect();
$alerte = new AnyTable($db, 'alertes', 'id', $id);     // $_GET['id']

$row = $alerte->fetchOne();

if ($row) {
    echo json_encode(value: ['alerte' => $row]);
} else {
    echo json_encode(['message' => "No records found!"]);
}



