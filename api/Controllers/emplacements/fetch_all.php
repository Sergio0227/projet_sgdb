<?php

require_once __DIR__ . '/../../../config/db_connect.php';
require_once __DIR__ . '/../../Models/emplacements.php';


$db = new Database();
$db = $db->connect();

$emplacement = new Emplacement($db, 'emplacements');

$res = $emplacement->fetchAll();
$resCount = $res->rowCount();

if ($resCount > 0) {

    $arr = array();
    while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
        $arr[] = $row;
    }
    $arr = $emplacement->buildTree($arr);

    $wrappedArr = [];
    foreach ($arr as $node) {
        $wrappedArr[] = [
            'request' => $node,
            'method' => 'GET',
            'URL' => 'http://localhost/sgdb_api/emplacements.php?id=' . $node['id']
        ];
    }

    echo json_encode($wrappedArr);

} else {
    echo json_encode(array('message' => "No records found!"));
}

