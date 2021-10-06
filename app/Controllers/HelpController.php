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

class HelpController extends Controller
{

    public function __construct($route = "/", Request $request = null)
    {
        $this->request = $request;
        if (Gate::get()) {
            switch ($route) {
                case "/":
                    include VIEWS . "help" . DIRECTORY_SEPARATOR . "index.php";
                    break;
                case "/tos":
                    include VIEWS . "help" . DIRECTORY_SEPARATOR . "tos.php";
                    break;
                case "/faq":
                    include VIEWS . "help" . DIRECTORY_SEPARATOR . "faq.php";
                    break;
            }
        }else{
            Gate::echo(405);
        }
    }


}