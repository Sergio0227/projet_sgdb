<?php

require_once __DIR__ . '/../../../config/db_connect.php';
require_once __DIR__ . '/../../Models/tools/any_table.php';


$db = new Database();
$db = $db->connect();

$type = new AnyTable($db, 'types');

$data = json_decode(file_get_contents("php://input"));

$type->fields['libelle'] = $data->description;


$id = $type->postData();

if ($id) {
    echo json_encode(array('message' => 'Type added', 'request' => array('type' => 'GET', 'url' => 'http://localhost/sgdb_api/types.php?id=' .$id)));
} else {
    echo json_encode(array('message' => 'Type Not added, try again!'));
}