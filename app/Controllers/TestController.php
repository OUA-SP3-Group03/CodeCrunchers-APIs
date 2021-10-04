<?php
/**
 * Copyright Jack Harris
 * Peninsula Interactive - CodeCrunchers
 * Last Updated - 4/10/2021
 */

namespace app\controllers;

use app\core\Console;
use app\core\Controller;

class TestController extends Controller
{
    public function __construct(){
        Console::log("TestController Created");
    }

    public static function test(){
       Console::log("Test Static Method Called");
    }

}