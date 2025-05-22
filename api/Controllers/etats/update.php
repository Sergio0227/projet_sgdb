<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../../config/db_connect.php';
require_once __DIR__ . '/../../Models/tools/any_table.php';


$db = new Database();
$db = $db->connect();

$etat = new AnyTable($db, 'etats', 'id', $id);
$data = json_decode(file_get_contents("php://input"));


$etat->fields['libelle'] = $data->parent_id;


if ($etat->fetchOne() && $etat->putData()) {
    echo json_encode(array('message' => 'Etat update', 'request' => array('type' => 'GET', 'url' => 'http://localhost/sgdb_api/etats.php?id=' .$id)));
} else {
    echo json_encode(array('message' => 'Etat Not updated, try again!'));
}