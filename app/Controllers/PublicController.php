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

class PublicController extends Controller
{

    public function __construct(String $route = "/", Request $request = null)
    {
        $this->request = $request;
        $this->route = $route;

        if(Gate::get()) {
            switch ($route) {
                case "/style":
                    header("Content-type: text/css");
                    include RESOURCES."stylesheet.css";
                    break;
                case "/js":
                    include RESOURCES."userfunctions.php";
                    break;
                case "/logo":
                    header("Content-Type: image/png");
                   include RESOURCES."CodeCrunchers-Logo.png";
                    break;
                case "/brick-texture":
                    header("Content-Type: image/png");
                    include RESOURCES."brick.png";
                    break;
                case "/alpha-v2-screenshot":
                    header("Content-Type: image/png");
                    include RESOURCES."alpha-screenshot.png";
                    break;
            }
        }else{
            Gate::echo(405);
        }
    }

}