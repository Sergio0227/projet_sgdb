<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET, POST, DELETE, PUT');

$method = $_SERVER['REQUEST_METHOD'];
if (!in_array($method, ['GET', 'POST', 'DELETE', 'PUT'])) {
    http_response_code(405);
    echo json_encode(['message' => 'Method Not Allowed']);
    exit;
}


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($method === "GET") {
        require_once __DIR__ . '/../api/Controllers/elements/fetch_one.php';
    } else if ($method === "PUT") {
        require_once __DIR__ . '/../api/Controllers/elements/update.php';
    } else if ($method === "DELETE") {
        require_once __DIR__ . '/../api/Controllers/elements/delete.php';
    }
} else if (empty($_GET)){
    if ($method === "GET") {
        require_once __DIR__ . '/../api/Controllers/elements/fetch_all.php';
    } else if ($method === "POST") {
        require_once __DIR__ . '/../api/Controllers/elements/create.php';
    }
}