<?php

require_once __DIR__ . '/../../../config/db_connect.php';
require_once __DIR__ . '/../../Models/tools/any_table.php';


$db = new Database();
$db = $db->connect();

$etat = new AnyTable($db, 'etats');

$data = json_decode(file_get_contents("php://input"));

$etat->fields['libelle'] = $data->description;


$id = $etat->postData();

if ($id) {
    echo json_encode(array('message' => 'Etat added', 'request' => array('type' => 'GET', 'url' => 'http://localhost/sgdb_api/etats.php?id=' .$id)));
} else {
    echo json_encode(array('message' => 'Etat Not added, try again!'));
}