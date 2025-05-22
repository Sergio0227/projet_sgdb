<?php

require_once __DIR__ . '/../../../config/db_connect.php';
require_once __DIR__ . '/../../Models/tools/any_table.php';

$db = new Database();
$db = $db->connect();

$emplacement = new AnyTable($db, 'emplacements', 'id', $id);

if ($id) {
    if ($emplacement->fetchOne() && $emplacement->delete()) {
        echo json_encode(array('message' => 'Emplacement deleted'));
    } else {
        echo json_encode(array('message' => 'Emplacement Not deleted, try again!'));
    }
} else {
    echo json_encode(array('message' => "Error: Emplacement ID is missing!"));
}