<?php
/**
 * Copyright Jack Harris
 * Peninsula Interactive - CodeCrunchers
 * Last Updated - 6/10/2021
 */

namespace app\controllers;

use app\core\Console;
use app\core\Controller;
use app\core\Gate;
use app\core\Request;
use app\rules\AddScoreRequestRule;
use app\services\Score;

class ScoreController extends Controller
{

    public function __construct(String $route = "/", Request $request = null)
    {
        //set this request
        $this->request = $request;

        //set the post gate
        if(Gate::post()){
            //echo an error if the gate is not matching post
            echo Gate::getError(Gate::post());
        }else{
            switch ($route){
                case "/add":
                    $this->request->validate(new AddScoreRequestRule());
                    if($this->request->getErrors() != []){
                        Console::log(json_encode($this->request->getErrors()));
                    }else{
                        $result = Score::add($this->request);
                        if($result){
                            echo "score added";
                        }
                    }
                    break;
                case "/get":
                    echo "Get high scores end point";
                    break;
            }
        }

    }

}