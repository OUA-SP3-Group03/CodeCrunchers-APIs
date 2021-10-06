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
use app\rules\LoginRequestRule;
use app\rules\SignupRequestRule;
use app\services\User;

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
                    //echo "Authentication Login end point **** ADD LATER **** \n";
                    $this->request->validate(new LoginRequestRule());
                    if($this->request->getErrors() != []) {
                        Console::log(json_encode($this->request->getErrors()));
                    }else{
                        $result = User::login($this->request);
                        if($result != null){
                            echo "Welcome ".$result[User::$first_name]." ".$result[User::$last_name];
                        }else{
                            echo "Login failed, please check your email and password and try again";
                        }
                    }
                    break;
                case "/logout":
                    echo "Authentication Logout **** ADD LATER ****\n";
                    break;
                case "/check":
                    echo "Authentication Token Check **** ADD LATER ****\n";
                    break;
                case "/add":

                    //firstly to create the signup we validate the request with our signup rule
                    $this->request->validate(new SignupRequestRule());
                    //now we check to ensure we have no errors, if we do we output them, else we proceed
                    if($this->request->getErrors() != []){
                        Console::log(json_encode($this->request->getErrors()));
                    }else{
                       $result = User::create($this->request);
                       if($result){
                           echo "user created";
                       }

                    }
            }
        }
    }

}