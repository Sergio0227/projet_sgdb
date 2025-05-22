<?php

require_once __DIR__ . '/../../../config/db_connect.php';
require_once __DIR__ . '/../../Models/tools/any_table.php';


$db = new Database();
$db = $db->connect();

$temperature = new AnyTable($db, 'temperatures');

$res = $temperature->fetchAll();
$resCount = $res->rowCount();

if ($resCount > 0) {

    $arr = array();
    while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
        $arr[] = ['temperature' => $row, 'request' => 'GET', 'url' => 'http://localhost/sgdb_api/temperatures.php?id=' .$row['id']];
    }
    echo json_encode($arr);


} else {
    echo json_encode(array('message' => "No records found!"));
}

