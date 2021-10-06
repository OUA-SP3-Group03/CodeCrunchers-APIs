<?php
/**
 * Copyright Jack Harris
 * Peninsula Interactive - CodeCrunchers
 * Last Updated - 6/10/2021
 */

namespace app\services;

use app\core\Service;
use app\core\Table;
use app\database\tokens_game;
use app\database\tokens_web;
use Exception;

class Token extends  Service
{
    //array mapping
    private static int $user_id = 0;
    private static int $token = 1;
    private static int $expiry = 2;

    //set the length of the tokens you wish to generate
    private static int $tokenLength = 50;
    //set the token expiry time in days
    private static int $tokenExpiry = 7;

    /**
     * @throws Exception
     */
    //**** CREATE TOKEN STATIC FUNCTION ****\\
    public static function create(String $type, int $user_id): bool{

        //outcome variable for this function, returns at end of function as true or false.
        $outcome = false;

        //create database variable

        $database = match ($type) {
            "game" => new tokens_game(),
            default => new tokens_web(),
        };

            //next we delete any existing record that may be left over in the table
            $database->deleteRowByPK($user_id);

            //finally, we create our values array and call the create row method in the database
            $values = [
                "user_id" => $user_id,
                "token" => self::generate($database),
                "expiry" => time() + self::$expiry * 24 * 60 * 60
            ];
            //check if it succeeded or not
            if($database->createRow($values)){
                $outcome = true;
            }

            return $outcome;
    }

    /**
     * @throws Exception
     */
    //**** GENERATE TOKEN FUNCTION ****\\
    //generates a token, then checks the database to ensure a token that matches that is currently not in use
    private static function generate(Table $database): string
    {
        $token = bin2hex(random_bytes(self::$tokenLength));
        while($database->getRowByValue("token",$token) != null){
            $token = bin2hex(random_bytes(self::$tokenLength));
        }

        return $token;
    }

}