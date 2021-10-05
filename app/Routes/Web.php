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
        $default->addRoute("/register","DefaultController");
        $default->addRoute("/scores","DefaultController");
        $default->addRoute("/account","DefaultController");
        //finally, register the route group with the core route service provider using the correct parent prefix for this group
        $routeServiceProvider->addRouteGroup("/",$default);

        $help = new RouteGroup();
        $help->addRoute("/","HelpController");
        $help->addRoute("/tos","HelpController");
        $help->addRoute("/faq","HelpController");
        $routeServiceProvider->addRouteGroup("/help",$help);
    }


}