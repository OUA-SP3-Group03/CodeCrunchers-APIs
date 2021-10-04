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
    private array $routeGroups;

    //****  ADD A ROUTE GROUP ****\\
    public function addRouteGroup(String $prefix,RouteGroup $routeGroup){
        $this->routeGroups[$prefix] = $routeGroup;
    }

    //****  LOAD ROUTE FUNCTION TO CHECK THE ROUTE GROUPS AND ROUTES FOR A URL MATCH ****\\
    public function loadRoute(array $url): int
    {
        Console::log(json_encode($url));

        //first check if we have an url string set at position 0, if so proceed
        if (isset($url[0])) {

            //now check if the array key exists in the route groups, if so proceed to the next check
            if (array_key_exists($url[0], $this->routeGroups)) {

                //set the selected route group to a local variable
                $selectedGroup = $this->routeGroups[$url[0]];

                //check if the next url string is in the array of routes as a key
                if(isset($url[1]) && array_key_exists($url[1],$selectedGroup->getRoutes())){
                    Console::log("Route Found: ".$url[1]);
                    return 200;

                //else we need to check to see if a default index route is valid, if so load it
                }else if(array_key_exists("/",$selectedGroup->getRoutes())){
                    Console::log("Route Found: /");
                    return 200;
                }

            }else{
                //load default routes
                $selectedGroup = $this->routeGroups["/"];
                if(array_key_exists($url[0],$selectedGroup->getRoutes())){
                    Console::log("Route Found: ".$url[0]);
                    return 200;
                }
            }
        }
            return 404;
        }
    }