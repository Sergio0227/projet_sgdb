<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../../config/db_connect.php';
require_once __DIR__ . '/../../Models/tools/any_table.php';


$db = new Database();
$db = $db->connect();

$usage = new AnyTable($db, 'usages', 'id', $id);
$data = json_decode(file_get_contents("php://input"));


$usage->fields['libelle'] = $data->parent_id;


if ($usage->fetchOne() && $usage->putData()) {
    echo json_encode(array('message' => 'Usage update', 'request' => array('type' => 'GET', 'url' => 'http://localhost/sgdb_api/usages.php?id=' .$id)));
} else {
    echo json_encode(array('message' => 'Usage Not updated, try again!'));
}