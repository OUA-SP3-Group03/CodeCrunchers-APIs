<?php
/**
 * Copyright Jack Harris
 * Peninsula Interactive - CodeCrunchers
 * Last Updated - 4/10/2021
 */

namespace app\routes;

use app\core\RouteGroup;
use app\providers\RouteServiceProvider;

class Web
{
    //**** WEB CLASS Contains all the route groups relating to the website ****\\
    public function __construct(RouteServiceProvider $routeServiceProvider){

        //create core route group first
        $default = new RouteGroup();
        //next add the routes we want to the group, firstly add the prefix, then the relevant controller
        $default->addRoute("/","DefaultController");
        $default->addRoute("/login","DefaultController");
        $default->addRoute("/signup","DefaultController");
        $default->addRoute("/account","DefaultController");
        $default->addRoute("/help","DefaultController");
        //finally, register the route group with the core route service provider using the correct parent prefix for this group
        $routeServiceProvider->addRouteGroup("/",$default);

        $test = new RouteGroup();
        $test->addRoute("/","TestController");
        $test->addRoute("/meme","TestController");
        $test->addRoute("/jack","TestController");
        $routeServiceProvider->addRouteGroup("/test",$test);

    }

}