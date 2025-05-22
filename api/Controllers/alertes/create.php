<?php

require_once __DIR__ . '/../../../config/db_connect.php';
require_once __DIR__ . '/../../Models/tools/any_table.php';


$db = new Database();
$db = $db->connect();

$alerte = new AnyTable($db, 'alertes');

$data = json_decode(file_get_contents("php://input"));

$alerte->fields['temp_id'] = $data->temp_id;
$alerte->fields['urgence'] = $data->urgence;
$alerte->fields['solved'] = $data->solved;


$id = $alerte->postData();

if ($id) {
    echo json_encode(array('message' => 'Alerte added', 'request' => array('type' => 'GET', 'url' => 'http://localhost/sgdb_api/alertes.php?id=' .$id)));
} else {
    echo json_encode(array('message' => 'Alerte Not added, try again!'));
}