<?php
/**
 * Copyright Jack Harris
 * Peninsula Interactive - CodeCrunchers
 * Last Updated - 4/10/2021
 */

namespace app\controllers;

use app\core\Console;
use app\core\Controller;
use app\core\Gate;
use app\core\Request;

class DefaultController extends Controller
{

    public function __construct($route = "/", Request $request = null)
    {
        $this->request = $request;
        if (Gate::get()) {
            echo Gate::getError(Gate::get());
        } else {
            switch ($route) {
                case "/":
                    include VIEWS . "default" . DIRECTORY_SEPARATOR . "index.php";
                    break;
                case "/login":
                    include VIEWS . "default" . DIRECTORY_SEPARATOR . "login.php";
                    break;
                case "/register":
                    include VIEWS . "default" . DIRECTORY_SEPARATOR . "register.php";
                    break;
                case "/help":
                    include VIEWS . "default" . DIRECTORY_SEPARATOR . "help.php";
                    break;
                case "/scores":
                    include VIEWS . "default" . DIRECTORY_SEPARATOR . "scores.php";
                    break;
            }
        }
    }


}