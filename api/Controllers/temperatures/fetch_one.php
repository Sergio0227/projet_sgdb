<?php

require_once __DIR__ . '/../../../config/db_connect.php';
require_once __DIR__ . '/../../Models/tools/any_table.php';


$db = Database::connect();
$temperature = new AnyTable($db, 'temperatures', 'id', $id);     // $_GET['id']

$row = $temperature->fetchOne();

if ($row) {
    echo json_encode(value: ['temperature' => $row]);
} else {
    echo json_encode(['message' => "No records found!"]);
}



