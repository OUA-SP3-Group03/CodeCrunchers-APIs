<?php
/**
 * Copyright Jack Harris
 * Peninsula Interactive - CodeCrunchers
 * Last Updated - 6/10/2021
 */

namespace app\services;

use app\core\Request;
use app\core\Service;
use app\database\scores;

class ScoreService extends Service
{
    public static function add(Request $request): bool
    {
        //create instance of the score database class
        $score_db = new scores();

        //create a random score id
        $score_id = rand(0,10**6);

        //check that that id is available, if not regenerate until we get an unused one
        while($score_db->getRowByPK($score_id)  != null){
            //try a new random number
            $score_id = rand(0,10**6);
        }

        //make sure to cast integers before passing values array
        $values = [
            "id" => $score_id,
            "user_id" => (int)$request->getPostData()["user_id"],
            "time_stamp" => time(),
            "score" => (int) $request->getPostData()["score"],
            "level" => $request->getPostData()["level"]
        ];

        //return the true or false result
        return $score_db->createRow($values);
    }

    public static function getScores(int $limit = null): array{
        $score_db = new scores;
        $allScores = $score_db->getAllRows("DESC");

        $scores = [];

        if($limit == null){
            $limit = count($allScores);
        }

        if($limit > count($allScores) || $limit < 0){
            $limit = count($allScores);
        }

        $i =0;
        while($i < $limit){

            $tempArray = [];

            $tempArray["username"] = UserService::getUsername($allScores[$i][1]);
            $tempArray["score"] = $allScores[$i][3];
            $tempArray["date"] = $allScores[$i][2];
            $scores[$i] = $tempArray;

            $i++;
        }


        return $scores;
    }

}