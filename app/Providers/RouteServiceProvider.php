<?php
/**
 * Copyright Jack Harris
 * Peninsula Interactive - CodeCrunchers
 * Last Updated - 4/10/2021
 */

namespace app\providers;

use app\core\Request;
use app\core\RouteGroup;
use app\core\Provider;

class RouteServiceProvider extends Provider
{
    private array $webRouteGroups;
    private array $apiRouteGroups;

    public function __construct(Request $request){
        $this->apiRouteGroups = [];
        $this->webRouteGroups = [];
        $this->request = $request;
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
    public function loadRoute(array $url, bool $api = false)
    {

        if($api == true){
            $routeGroups = $this->apiRouteGroups;
        }else{
            $routeGroups = $this->webRouteGroups;
        }

        //first check if we have an url string set at position 0, if so proceed
        if (isset($url[0])) {

            //now check if the array key exists in the route groups, if so proceed to the next check
            if (array_key_exists($url[0], $routeGroups)) {

                //set the selected route group to a local variable
                $selectedGroup = $routeGroups[$url[0]];

                //check if the next url string is in the array of routes as a key
                if(isset($url[1]) && array_key_exists($url[1],$selectedGroup->getRoutes())){
                    $namespace = "app\controllers\ ";
                    $namespace = substr($namespace,0,-1);
                    $callback = $namespace.$selectedGroup->getRoutes()[$url[1]];
                    return new $callback($url[1], $this->request);

                //else we need to check to see if a default index route is valid, if so load it
                }else if(array_key_exists("/",$selectedGroup->getRoutes()) && !isset($url[1])){
                    $namespace = "app\controllers\ ";
                    $namespace = substr($namespace,0,-1);
                    $callback = $namespace.$selectedGroup->getRoutes()["/"];
                    return new $callback("/", $this->request);
                }

            }else{
                //load default routes
                if (array_key_exists("/", $routeGroups)) {
                    $selectedGroup = $routeGroups["/"];
                    if (array_key_exists($url[0], $selectedGroup->getRoutes())) {

                        $namespace = "app\controllers\ ";
                        $namespace = substr($namespace, 0, -1);
                        $callback = $namespace . $selectedGroup->getRoutes()[$url[0]];
                        return new $callback($url[0], $this->request);
                    }
                }
            }
        }
            return null;
        }
    }