<?php

require_once __DIR__ . '/../../../config/db_connect.php';
require_once __DIR__ . '/../../Models/tools/any_table.php';

$db = new Database();
$db = $db->connect();

$temperature = new AnyTable($db, 'temperatures', 'id', $id);

if ($id) {
    if ($temperature->fetchOne() && $temperature->delete()) {
        echo json_encode(array('message' => 'Temperature deleted'));
    } else {
        echo json_encode(array('message' => 'Temperature Not deleted, try again!'));
    }
} else {
    echo json_encode(array('message' => "Error: Temperature ID is missing!"));
}