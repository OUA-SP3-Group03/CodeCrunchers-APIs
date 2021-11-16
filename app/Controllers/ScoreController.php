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
use app\services\ScoreService;

class ScoreController extends Controller
{

    public function __construct(String $route = "/", Request $request = null)
    {
        //set this request
        $this->request = $request;
        $this->route = $route;

        header('Content-Type: application/json; charset=utf-8');

        //set the post gate
        if(Gate::post()){
            switch ($route){
                case "/add":
                    $this->request->validate(new AddScoreRequestRule());
                    if($this->request->getErrors() != []){
                        Console::log(json_encode(["success"=>false,"errors"=>$this->request->getErrors()]));
                    }else{
                        $result = ScoreService::add($this->request);
                        if($result){
                            Console::log(json_encode(["success"=>true]));
                        }
                    }
                    break;
                case "/get":
                        Console::log(json_encode(["success" => true, "scores" => ScoreService::getScores(50)]));
                    break;
            }
        }else{
            Gate::echo(405);
        }

    }

}