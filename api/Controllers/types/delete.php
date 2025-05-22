<?php

require_once __DIR__ . '/../../../config/db_connect.php';
require_once __DIR__ . '/../../Models/tools/any_table.php';

$db = new Database();
$db = $db->connect();

$type = new AnyTable($db, 'types', 'id', $id);

if ($id) {
    if ($type->fetchOne() && $type->delete()) {
        echo json_encode(array('message' => 'Type deleted'));
    } else {
        echo json_encode(array('message' => 'Type Not deleted, try again!'));
    }
} else {
    echo json_encode(array('message' => "Error: Type ID is missing!"));
}