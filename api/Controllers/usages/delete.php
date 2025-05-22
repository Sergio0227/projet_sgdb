<?php

require_once __DIR__ . '/../../../config/db_connect.php';
require_once __DIR__ . '/../../Models/tools/any_table.php';

$db = new Database();
$db = $db->connect();

$usage = new AnyTable($db, 'usages', 'id', $id);

if ($id) {
    if ($usage->fetchOne() && $usage->delete()) {
        echo json_encode(array('message' => 'Usage deleted'));
    } else {
        echo json_encode(array('message' => 'Usage Not deleted, try again!'));
    }
} else {
    echo json_encode(array('message' => "Error: Usage ID is missing!"));
}