<?php

namespace SGDB_API\Routes;

class Router
{
    private $routesArray;
    private $uri;

    public function __construct($routes)
    {
        $this->routesArray = $routes;
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $regexp = "#^/sgdb_api/?(.*)$#i";
        if (preg_match($regexp, $path, $Tcaptures) === 1) {
            $this->uri = rtrim($Tcaptures[1], '/');
        } else {
            throw new \Exception("Route not found: {$this->uri}");
        }
    }

    public function get_Controller()
    {
        if (array_key_exists($this->uri, $this->routesArray)) {
            $routeMapping = $this->routesArray[$this->uri];
            $controllerName = key($routeMapping);
            return $controllerName;
        }
        throw new \Exception("Route not found: {$this->uri}");
    }

    public function get_Action()
    {
        $controllerName = $this->get_Controller();
        $routeMapping = $this->routesArray[$this->uri];
        if (array_key_exists($this->uri, $this->routesArray)) {
            $actionName = $routeMapping[$controllerName];
            return $actionName;
        }
        throw new \Exception("Action not found for controller: {$controllerName}");

    }
}