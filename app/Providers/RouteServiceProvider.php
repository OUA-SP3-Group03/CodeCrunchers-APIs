<?php
/**
 * Copyright Jack Harris
 * Peninsula Interactive - CodeCrunchers
 * Last Updated - 4/10/2021
 */

namespace app\providers;

use app\core\Console;
use app\core\RouteGroup;
use app\core\Provider;

class RouteServiceProvider extends Provider
{
    private array $webRouteGroups;
    private array $apiRouteGroups;

    public function __construct(){
        $this->apiRouteGroups = [];
        $this->webRouteGroups = [];
    }

    //****  ADD A WEB ROUTE GROUP ****\\
    public function addRouteGroup(String $prefix,RouteGroup $routeGroup){
        $this->webRouteGroups[$prefix] = $routeGroup;
    }
    //**** ADD A API ROUTE GROUP ****\\
    public function addApiRouteGroup(String $prefix,RouteGroup $routeGroup){
        $this->apiRouteGroups[$prefix] = $routeGroup;
    }

    //****  LOAD ROUTE FUNCTION TO CHECK THE ROUTE GROUPS AND ROUTES FOR A URL MATCH ****\\
    public function loadRoute(array $url)
    {


        //first check if we have an url string set at position 0, if so proceed
        if (isset($url[0])) {

            //now check if the array key exists in the route groups, if so proceed to the next check
            if (array_key_exists($url[0], $this->webRouteGroups)) {

                //set the selected route group to a local variable
                $selectedGroup = $this->webRouteGroups[$url[0]];

                //check if the next url string is in the array of routes as a key
                if(isset($url[1]) && array_key_exists($url[1],$selectedGroup->getRoutes())){
                    $namespace = "app\controllers\ ";
                    $namespace = substr($namespace,0,-1);
                    $callback = $namespace.$selectedGroup->getRoutes()[$url[1]];
                    return new $callback($url[1]);

                //else we need to check to see if a default index route is valid, if so load it
                }else if(array_key_exists("/",$selectedGroup->getRoutes()) && !isset($url[1])){
                    $namespace = "app\controllers\ ";
                    $namespace = substr($namespace,0,-1);
                    $callback = $namespace.$selectedGroup->getRoutes()["/"];
                    return new $callback("/");
                }

            }else{
                //load default routes
                $selectedGroup = $this->webRouteGroups["/"];
                if(array_key_exists($url[0],$selectedGroup->getRoutes())){

                    $namespace = "app\controllers\ ";
                    $namespace = substr($namespace,0,-1);
                    $callback = $namespace.$selectedGroup->getRoutes()[$url[0]];
                    return new $callback($url[0]);
                }
            }
        }
            return null;
        }

        //**** LOAD API ROUTE AND CHECK FOR CONTROLLER & ROUTE MATCHES RETURNS THE CONTROLLER ****\\
        public function  loadApiRoute(array $url){
            //first check if we have an url string set at position 0, if so proceed
            if (isset($url[0])) {

                //now check if the array key exists in the route groups, if so proceed to the next check
                if (array_key_exists($url[0], $this->apiRouteGroups)) {

                    //set the selected route group to a local variable
                    $selectedGroup = $this->apiRouteGroups[$url[0]];

                    //check if the next url string is in the array of routes as a key
                    if(isset($url[1]) && array_key_exists($url[1],$selectedGroup->getRoutes())){
                        $namespace = "app\controllers\ ";
                        $namespace = substr($namespace,0,-1);
                        $callback = $namespace.$selectedGroup->getRoutes()[$url[1]];
                        return new $callback($url[1]);

                        //else we need to check to see if a default index route is valid, if so load it
                    }else if(array_key_exists("/",$selectedGroup->getRoutes()) && !isset($url[1])){
                        $namespace = "app\controllers\ ";
                        $namespace = substr($namespace,0,-1);
                        $callback = $namespace.$selectedGroup->getRoutes()["/"];
                        return new $callback("/");
                    }

                }else{
                    //load default routes
                        $selectedGroup = $this->apiRouteGroups["/"];
                        if (array_key_exists($url[0], $selectedGroup->getRoutes())) {

                            $namespace = "app\controllers\ ";
                            $namespace = substr($namespace, 0, -1);
                            $callback = $namespace . $selectedGroup->getRoutes()[$url[0]];
                            return new $callback($url[0]);
                        }
                    }

            }
            return null;
        }
    }