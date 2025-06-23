<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once 'vendor/autoload.php';

use SGDB_API\Routes\Router;

try {
    $router = new Router(include 'Routes/Routes.php');
    $controllerName = $router->get_Controller();
    $actionName = $router->get_Action();
} catch (Exception $e) {
    $controllerName = "errorPage";
    $actionName = "page404";
}

$controllerPath = "SGDB_API\\Controllers\\" . $controllerName;

$method = $_SERVER['REQUEST_METHOD'];

$controller = new $controllerPath();
if ($actionName)
    $controller->$actionName();
else {
    if (isset($_GET['id'])) {
        if ($method == 'GET')
            $controller->fetchOne();
        else if ($method == 'PUT')
            $controller->update();
        else if ($method == 'DELETE')
            $controller->delete();
        else
            echo json_encode(['message' => 'Method Not Allowed']);
    } else {
        if ($method == 'GET')
            $controller->fetch();
        else if ($method == 'POST')
            $controller->create();
        else
            echo json_encode(['message' => 'Method Not Allowed']);
    }
}


