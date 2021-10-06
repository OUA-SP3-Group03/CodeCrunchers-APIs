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
use app\services\Cookie;
use app\services\Token;
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
                    //validate request with login request rules
                    $this->request->validate(new LoginRequestRule());
                    //check for any requests, if there are requests console log them
                    if($this->request->getErrors() != []) {
                       // Console::log(json_encode($this->request->getErrors()));
                        echo false;
                    }else{
                        //now we get the result of the user login and pass it the request
                        $result = User::login($this->request);
                        //if the result is not null we can see the login has worked, a failed login will return null
                        if($result != null){
                            //now we start our try catch loop for token creation
                            try {
                                //we set the token response to a new token and pass it the user id from the valid login as well as the token type from the request, this is either "web" or "game"
                                $token_response = Token::create($this->request->getPostData()["type"], $result[User::$user_id]);
                                //now we process the return for a web type
                                if($request->getPostData()["type"] == "web"){
                                    //echo true for success
                                   echo true;
                                    //create the cookie for the web
                                    Cookie::create("codecrunchers",$token_response["token"],7);
                                }else{
                                    //else we assume its the game type and return the token as json for the game to save
                                    echo json_encode($token_response);
                                }
                                //finally if we have any errors we print them to console
                            } catch (\Exception $e) {Console::log($e->getMessage());}

                        //else we have assumed that the core login failed and return false
                        }else{
                            //echo false for failed login attempt
                            echo false;
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
                    break;
                case "/get":

                    break;
            }
        }
    }

}