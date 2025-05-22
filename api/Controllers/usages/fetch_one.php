<?php

require_once __DIR__ . '/../../../config/db_connect.php';
require_once __DIR__ . '/../../Models/tools/any_table.php';


$db = Database::connect();
$usage = new AnyTable($db, 'usages', 'id', $id);     // $_GET['id']

$row = $usage->fetchOne();

if ($row) {
    echo json_encode(value: ['usage' => $row]);
} else {
    echo json_encode(['message' => "No records found!"]);
}



