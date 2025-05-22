<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../../config/db_connect.php';
require_once __DIR__ . '/../../Models/tools/any_table.php';


$db = new Database();
$db = $db->connect();

$alerte = new AnyTable($db, 'alertes', 'id', $id);
$data = json_decode(file_get_contents("php://input"));


$alerte->fields['temp_id'] = $data->temp_id;
$alerte->fields['urgence'] = $data->urgence;
$alerte->fields['solved'] = $data->solved;




if ($alerte->fetchOne() && $alerte->putData()) {
    echo json_encode(array('message' => 'Alerte update', 'request' => array('type' => 'GET', 'url' => 'http://localhost/sgdb_api/alertes.php?id=' .$id)));
} else {
    echo json_encode(array('message' => 'Alerte Not updated, try again!'));
}