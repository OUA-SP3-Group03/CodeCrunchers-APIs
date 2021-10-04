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

class AuthController extends Controller
{

    public function __construct(String $route = "/", Request $request = null)
    {
        $this->request = $request;

        if(Gate::post()) {
            echo Gate::getError(Gate::post());
        }else {
            switch ($route) {
                case "/login":
                    echo "Authentication Login end point **** ADD LATER ****";
                    print_r($request->getPostData());
                    break;
                case "/logout":
                    echo "Authentication Logout **** ADD LATER ****";
                    break;
                case "/check":
                    echo "Authentication Token Check **** ADD LATER ****";
                    break;
                case "/signup":
                    echo "Authentication Signup end point **** ADD LATER ****";
            }
        }
    }

}