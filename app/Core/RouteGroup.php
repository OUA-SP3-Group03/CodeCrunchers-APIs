<?php
/**
 * Copyright Jack Harris
 * Peninsula Interactive - CodeCrunchers
 * Last Updated - 4/10/2021
 */

namespace app\core;

class RouteGroup
{

    private array $routes;

    public function addRoute(String $key, String $controller){
        $this->routes[$key] = $controller;
    }

    public function getRoutes(){
        return $this->routes;
    }


}