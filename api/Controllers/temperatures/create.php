<?php

require_once __DIR__ . '/../../../config/db_connect.php';
require_once __DIR__ . '/../../Models/tools/any_table.php';


$db = new Database();
$db = $db->connect();

$temperature = new AnyTable($db, 'temperatures');

$data = json_decode(file_get_contents("php://input"));

$temperature->fields['libelle'] = $data->description;


$id = $temperature->postData();

if ($id) {
    echo json_encode(array('message' => 'Temperature added', 'request' => array('temperature' => 'GET', 'url' => 'http://localhost/sgdb_api/temperatures.php?id=' .$id)));
} else {
    echo json_encode(array('message' => 'Temperature Not added, try again!'));
}