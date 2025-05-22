<?php

require_once __DIR__ . '/../../../config/db_connect.php';
require_once __DIR__ . '/../../Models/tools/any_table.php';


$db = new Database();
$db = $db->connect();

$element = new AnyTable($db, 'elements');

$data = json_decode(file_get_contents("php://input"));

$element->fields['nom'] = $data->nom;
$element->fields['date_mise_function'] = $data->date_mise_function;
$element->fields['capacite'] = $data->capacite;
$element->fields['temp_max'] = $data->temp_max;
$element->fields['temp_min'] = $data->temp_min;
$element->fields['emplacement_id'] = $data->emplacement_id;
$element->fields['qr_code'] = $data->qr_code;
$element->fields['full'] = $data->full;
$element->fields['remarques'] = $data->remarques;
$element->fields['usage_id'] = $data->usage_id;
$element->fields['etat_id'] = $data->etat_id;
$element->fields['type_id'] = $data->type_id;

$id = $element->postData();

if ($id) {
    echo json_encode(array('message' => 'Element added', 'request' => array('type' => 'GET', 'url' => 'http://localhost/sgdb_api/elements.php?id=' .$id)));
} else {
    echo json_encode(array('message' => 'Element Not added, try again!'));
}