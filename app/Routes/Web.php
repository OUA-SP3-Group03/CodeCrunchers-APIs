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

        $default = new RouteGroup();
        $default->addRoute("/","DefaultController");
        $default->addRoute("/login","DefaultController");
        $default->addRoute("/signup","DefaultController");
        $default->addRoute("/account","DefaultController");
        $default->addRoute("/help","DefaultController");
        $routeServiceProvider->addRouteGroup("/",$default);

        $test = new RouteGroup();
        $test->addRoute("/","TestController");
        $test->addRoute("/meme","TestController");
        $test->addRoute("/jack","TestController");
        $routeServiceProvider->addRouteGroup("/test",$test);

        $auth = new RouteGroup();
        $auth->addRoute("/","AuthController");
        $auth->addRoute("/login","AuthController");
        $routeServiceProvider->addRouteGroup("/auth",$auth);



    }

}