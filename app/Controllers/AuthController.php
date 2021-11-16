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
use app\rules\CheckRequestRule;
use app\rules\GetRequestRule;
use app\rules\LoginRequestRule;
use app\rules\logoutRequestRule;
use app\rules\SignupRequestRule;
use app\services\CookieService;
use app\services\TokenService;
use app\services\UserService;

class AuthController extends Controller
{

    public function __construct(String $route = "/", Request $request = null)
    {
        $this->request = $request;
        $this->route = $route;

        header('Content-Type: application/json; charset=utf-8');

        if(Gate::post()) {
            switch ($route) {
                case "/login":
                    //validate request with login request rules
                    $this->request->validate(new LoginRequestRule());
                    //check for any requests, if there are requests console log them
                    if($this->request->getErrors() != []) {
                        echo json_encode(["success" => false,"errors"=>$this->request->getErrors()]);
                    }else{
                        //now we get the result of the user login and pass it the request
                        $result = UserService::login($this->request);
                        //if the result is not null we can see the login has worked, a failed login will return null
                        if($result != null){
                            //now we start our try catch loop for token creation
                            try {
                                //we set the token response to a new token and pass it the user id from the valid login as well as the token type from the request, this is either "web" or "game"
                                $token_response = TokenService::create($this->request->getPostData()["type"], $result[UserService::$user_id]);
                                //now we process the return for a web type
                                if($request->getPostData()["type"] == "web"){
                                    //echo true for success
                                    echo json_encode(["success" => true, "redirect"=>"/"]);
                                    //create the cookie for the web
                                    CookieService::create("codecrunchers",$token_response["token"],7);
                                }else{
                                    //else we assume its the game type and return the token as json for the game to save
                                    $token_response["success"] = true;
                                    echo json_encode($token_response);
                                }
                                //finally if we have any errors we print them to console
                            } catch (\Exception $e) {Console::log($e->getMessage());}

                        //else we have assumed that the core login failed and return false
                        }else{
                            //echo false for failed login attempt
                            echo json_encode(["success" => false]);
                        }
                    }
                    break;
                case "/logout":
                    //validate the logout request
                        $this->request->validate(new logoutRequestRule());
                        //check for any errors and output them if they are thrown
                        if($this->request->getErrors() == []) {
                            //always delete the cookie

                            //check if we are calling the web
                            if ($this->request->getPostData()["type"] == "web") {
                                echo json_encode(["success" => UserService::logoutWeb($this->request->getPostData()["token"]), "redirect" => "/login"]);
                            }
                            //check if we are calling the game
                            if ($this->request->getPostData()["type"] == "game") {
                                echo json_encode(["success" => UserService::logoutGame($this->request->getPostData()["token"]), "redirect" => "null"]);
                            }
                        }else{
                            //else we echo the errors and a success false variable
                            echo json_encode(["success" => false, "errors" => $this->request->getErrors()]);
                        }
                    break;
                case "/check":
                    $this->request->validate(new CheckRequestRule());
                    if($this->request->getErrors() == []){
                        if($this->request->getPostData()['type'] == "game"){
                            echo json_encode(["success" => UserService::checkGame($this->request->getPostData()['token'])]);
                        }else{
                            echo json_encode(["success" => UserService::checkWeb($this->request->getPostData()['game'])]);
                        }
                    }else{
                        echo json_encode(["success" => false, "errors" => $this->request->getErrors()]);
                    }

                    break;
                case "/add":
                    //firstly to create the signup we validate the request with our signup rule
                    $this->request->validate(new SignupRequestRule());
                    //now we check to ensure we have no errors, if we do we output them, else we proceed
                    if($this->request->getErrors() != []){
                        Console::log(json_encode(["success"=>false,"errors"=>$this->request->getErrors()]));
                    }else{
                       $result = UserService::create($this->request);
                       if($result){
                           Console::log(json_encode(["success"=>true]));
                       }
                    }
                    break;
                case "/get":
                    //firstly we validate the token
                    $this->request->validate(new GetRequestRule());
                    if($this->request->getErrors() != []){
                        Console::log(json_encode($this->request->getErrors()));
                    }else{
                        $userData = UserService::getInfo($this->request->getPostData()['token']);
                        if($userData != []) {
                            Console::log(json_encode(["success"=>true,"username" => $userData[1],"user_id"=>$userData[0] ,"first_name" => $userData[2], "last_name" => $userData[3], "email" => $userData[4]]));
                        }else{
                            Console::log(json_encode(["success"=>false]));
                        }
                    }
                    break;
            }
        }else{
            Gate::echo(405);
        }
    }

}