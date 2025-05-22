<?php

require_once __DIR__ . '/../../../config/db_connect.php';
require_once __DIR__ . '/../../Models/tools/any_table.php';


$db = new Database();
$db = $db->connect();

$emplacement = new AnyTable($db, 'emplacements');

$data = json_decode(file_get_contents("php://input"));

$emplacement->fields['parent_id'] = $data->parent_id;
$emplacement->fields['description'] = $data->description;


$id = $emplacement->postData();

if ($id) {
    echo json_encode(array('message' => 'Emplacement added', 'request' => array('type' => 'GET', 'url' => 'http://localhost/sgdb_api/emplacements.php?id=' .$id)));
} else {
    echo json_encode(array('message' => 'Emplacement Not added, try again!'));
}