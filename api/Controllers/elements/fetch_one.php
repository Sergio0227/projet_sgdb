<?php

require_once __DIR__ . '/../../../config/db_connect.php';
require_once __DIR__ . '/../../Models/tools/any_table.php';


$db = Database::connect();
$element = new AnyTable($db, 'elements', 'id', $id);     // $_GET['id']

$row = $element->fetchOne();

if ($row) {
    echo json_encode(value: ['element' => $row]);
} else {
    echo json_encode(['message' => "No records found!"]);
}



