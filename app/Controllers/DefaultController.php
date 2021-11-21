<?php
/**
 * Copyright Jack Harris
 * Peninsula Interactive - CodeCrunchers
 * Last Updated - 4/10/2021
 */

namespace app\controllers;

use app\core\Controller;
use app\core\Gate;
use app\core\Request;

class DefaultController extends Controller
{

    public function __construct($route = "/", Request $request = null)
    {
        $this->request = $request;
        $this->route = $route;

        if (Gate::get()) {
            switch ($route) {
                case "/":
                    include VIEWS . "default" . DIRECTORY_SEPARATOR . "index.php";
                    break;
                case "/login":
                    if(!Gate::loggedIn()) {
                        include VIEWS . "default" . DIRECTORY_SEPARATOR . "login.php";
                    }else{
                        Gate::redirect("/");
                    }
                    break;
                case "/register":
                    include VIEWS . "default" . DIRECTORY_SEPARATOR . "register.php";
                    break;
                case "/account":
                    if(Gate::loggedIn()) {
                        include VIEWS . "default" . DIRECTORY_SEPARATOR . "account.php";
                    }else{
                        Gate::redirect("/login");
                    }
                    break;
                case "/scores":
                        include VIEWS . "default" . DIRECTORY_SEPARATOR . "scores.php";
                    break;
                case "/credits":
                    header("Location: http://localhost/download");
                    break;
                case "/download":
                    include VIEWS."default".DIRECTORY_SEPARATOR."download.php";
                    break;
                case "/terms-of-service":
                    include VIEWS."default".DIRECTORY_SEPARATOR."tos.php";
                    break;
            }
        }else{
           Gate::echo(405);
        }
    }


}