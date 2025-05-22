<?php

require_once __DIR__ . '/../../../config/db_connect.php';
require_once __DIR__ . '/../../Models/tools/any_table.php';

$db = new Database();
$db = $db->connect();

$alerte = new AnyTable($db, 'alertes', 'id', $id);

if ($id) {
    if ($alerte->fetchOne() && $alerte->delete()) {
        echo json_encode(array('message' => 'Alerte deleted'));
    } else {
        echo json_encode(array('message' => 'Alerte Not deleted, try again!'));
    }
} else {
    echo json_encode(array('message' => "Error: Alerte ID is missing!"));
}