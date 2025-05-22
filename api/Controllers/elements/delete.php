<?php

require_once __DIR__ . '/../../../config/db_connect.php';
require_once __DIR__ . '/../../Models/tools/any_table.php';

$db = new Database();
$db = $db->connect();

$element = new AnyTable($db, 'elements', 'id', $id);

if ($id) {
    if ($element->delete() && $element->fetchOne()) {
        echo json_encode(array('message' => 'Element deleted'));
    } else {
        echo json_encode(array('message' => 'Element Not deleted, try again!'));
    }
} else {
    echo json_encode(array('message' => "Error: Element ID is missing!"));
}