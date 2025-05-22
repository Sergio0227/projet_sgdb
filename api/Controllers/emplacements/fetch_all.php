<?php

require_once __DIR__ . '/../../../config/db_connect.php';
require_once __DIR__ . '/../../Models/tools/any_table.php';


$db = new Database();
$db = $db->connect();

$emplacement = new AnyTable($db, 'emplacements');

$res = $emplacement->fetchAll();
$resCount = $res->rowCount();

if ($resCount > 0) {

    $arr = array();
    while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
        $arr[] = ['emplacement' => $row, 'request' => 'GET', 'url' => 'http://localhost/sgdb_api/emplacements.php?id=' .$row['id']];
    }
    echo json_encode($arr);


} else {
    echo json_encode(array('message' => "No records found!"));
}

