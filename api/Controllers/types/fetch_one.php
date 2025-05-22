<?php

require_once __DIR__ . '/../../../config/db_connect.php';
require_once __DIR__ . '/../../Models/tools/any_table.php';


$db = Database::connect();
$type = new AnyTable($db, 'types', 'id', $id);     // $_GET['id']

$row = $type->fetchOne();

if ($row) {
    echo json_encode(value: ['type' => $row]);
} else {
    echo json_encode(['message' => "No records found!"]);
}



