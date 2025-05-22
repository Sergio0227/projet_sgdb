<?php

require_once __DIR__ . '/../../../config/db_connect.php';
require_once __DIR__ . '/../../Models/tools/any_table.php';


$db = new Database();
$db = $db->connect();

$usage = new AnyTable($db, 'usages');

$data = json_decode(file_get_contents("php://input"));

$usage->fields['libelle'] = $data->description;


$id = $usage->postData();

if ($id) {
    echo json_encode(array('message' => 'Usage added', 'request' => array('type' => 'GET', 'url' => 'http://localhost/sgdb_api/usages.php?id=' .$id)));
} else {
    echo json_encode(array('message' => 'Usage Not added, try again!'));
}