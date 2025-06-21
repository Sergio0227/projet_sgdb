<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../../config/db_connect.php';
require_once __DIR__ . '/../../Models/emplacements.php';


$db = new Database();
$db = $db->connect();

$emplacement = new Emplacement($db, 'emplacements', 'id', $id);
$data = json_decode(file_get_contents("php://input"));


$emplacement->fields['parent_id'] = $data->parent_id;
$emplacement->fields['description'] = $data->description;


if ($emplacement->fetchOne() && $emplacement->putData()) {
    echo json_encode(array('message' => 'Emplacement update', 'request' => array('type' => 'GET', 'url' => 'http://localhost/sgdb_api/emplacements.php?id=' .$id)));
} else {
    echo json_encode(array('message' => 'Emplacement Not updated, try again!'));
}