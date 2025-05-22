<?php

require_once __DIR__ . '/../../../config/db_connect.php';
require_once __DIR__ . '/../../Models/tools/any_table.php';

$db = new Database();
$db = $db->connect();

$etat = new AnyTable($db, 'etats', 'id', $id);

if ($id) {
    if ($etat->fetchOne() && $etat->delete()) {
        echo json_encode(array('message' => 'Etat deleted'));
    } else {
        echo json_encode(array('message' => 'Etat Not deleted, try again!'));
    }
} else {
    echo json_encode(array('message' => "Error: Etat ID is missing!"));
}