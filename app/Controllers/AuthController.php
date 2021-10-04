<?php
/**
 * Copyright Jack Harris
 * Peninsula Interactive - CodeCrunchers
 * Last Updated - 4/10/2021
 */

namespace app\controllers;

use app\core\Console;
use app\core\Controller;

class AuthController extends Controller
{

    public function __construct($route = "/")
    {
        Console::log("Auth Controller Created");
        switch ($route){
            case "/":
                Console::log($route);
                include VIEWS."auth".DIRECTORY_SEPARATOR."index.php";
                break;
            case "/login":
                Console::log($route);
                include VIEWS."auth".DIRECTORY_SEPARATOR."login.php";
                break;
        }
    }

}