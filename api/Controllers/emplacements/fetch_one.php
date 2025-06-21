<?php

require_once __DIR__ . '/../../../config/db_connect.php';
require_once __DIR__ . '/../../Models/emplacements.php';

$db = Database::connect();
$emplacement = new Emplacement($db, 'emplacements', 'id', $id); // $id from $_GET['id']

$res = $emplacement->fetchAll();
$arr = [];
while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
    $arr[] = $row;
}
$tree = $emplacement->buildTree($arr);

function findNodeById($nodes, $id)
{
    foreach ($nodes as $node) {
        if ($node['id'] == $id)
            return $node;
        if (!empty($node['children'])) {
            $found = findNodeById($node['children'], $id);
            if ($found)
                return $found;
        }
    }
    return null;
}

$node = findNodeById($tree, $id);

if ($node) {
    echo json_encode([
        'emplacement' => $node]);
} else {
    echo json_encode(['message' => "No records found!"]);
}