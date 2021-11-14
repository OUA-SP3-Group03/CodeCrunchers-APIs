<?php
/**
 * Copyright Jack Harris
 * Peninsula Interactive - CodeCrunchers
 * Last Updated - 4/10/2021
 */

namespace app\routes;

use app\core\RouteGroup;
use app\providers\RouteServiceProvider;

class Api
{
    //**** API CLASS Contains all the route groups relating to the API connection ****\\

    public function __construct(RouteServiceProvider $routeServiceProvider)
    {
        $auth = new RouteGroup();
        $auth->addRoute("/login","AuthController");
        $auth->addRoute("/logout","AuthController");
        $auth->addRoute("/check","AuthController");
        $auth->addRoute("/add","AuthController");
        $routeServiceProvider->addApiRouteGroup("/auth",$auth);


        $score = new RouteGroup();
        $score->addRoute("/add","ScoreController");
        $score->addRoute("/get","ScoreController");
        $routeServiceProvider->addApiRouteGroup("/score",$score);

        $public = new RouteGroup();
        $public->addRoute("/style","PublicController");
        $public->addRoute("/js","PublicController");
        $public->addRoute("/logo","PublicController");
        $routeServiceProvider->addApiRouteGroup("/public",$public);

    }

}