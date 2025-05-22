<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../../config/db_connect.php';
require_once __DIR__ . '/../../Models/tools/any_table.php';


$db = new Database();
$db = $db->connect();

$type = new AnyTable($db, 'types', 'id', $id);
$data = json_decode(file_get_contents("php://input"));


$type->fields['libelle'] = $data->parent_id;


if ($type->fetchOne() && $type->putData()) {
    echo json_encode(array('message' => 'Type update', 'request' => array('type' => 'GET', 'url' => 'http://localhost/sgdb_api/types.php?id=' .$id)));
} else {
    echo json_encode(array('message' => 'Type Not updated, try again!'));
}