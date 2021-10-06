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
                    if(Gate::loggedIn()){
                        include VIEWS . "default" . DIRECTORY_SEPARATOR . "scores.php";
                    }else {
                        Gate::echo(403);
                    }
                    break;
            }
        }else{
           Gate::echo(405);
        }
    }


}