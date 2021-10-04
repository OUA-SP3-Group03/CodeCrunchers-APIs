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

class DefaultController extends Controller
{

    public function __construct($route = "/")
    {
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
            }
        }
    }


}