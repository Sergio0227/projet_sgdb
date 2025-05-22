<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../../config/db_connect.php';
require_once __DIR__ . '/../../Models/tools/any_table.php';


$db = new Database();
$db = $db->connect();

$temperature = new AnyTable($db, 'temperatures', 'id', $id);
$data = json_decode(file_get_contents("php://input"));


$temperature->fields['libelle'] = $data->parent_id;


if ($temperature->fetchOne() && $temperature->putData()) {
    echo json_encode(array('message' => 'Temperature update', 'request' => array('temperature' => 'GET', 'url' => 'http://localhost/sgdb_api/temperatures.php?id=' .$id)));
} else {
    echo json_encode(array('message' => 'Temperature Not updated, try again!'));
}