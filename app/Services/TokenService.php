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

class TokenService extends  Service
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
    public static function create(String $type, int $user_id): ?array{

        //outcome variable for this function, returns at end of function as true or false.
        $outcome = false;

        //create database variable

        $database = match ($type) {
            "game" => new tokens_game(),
            default => new tokens_web(),
        };

            //next we delete any existing record that may be left over in the table
            $rowCheck = $database->getRowByValue("user_id",$user_id);
            if($rowCheck != null) {
                $database->deleteRowByPK($rowCheck[self::$token]);
            }

            //finally, we create our values array and call the create row method in the database
            $values = [
                "user_id" => $user_id,
                "token" => self::generate($database),
                "expiry" => time() + self::$expiry * 24 * 60 * 60
            ];
            //check if it succeeded or not
            if($database->createRow($values)){
                return ["token" => $database->getRowByValue("user_id",$user_id)[self::$token]];
            }else {
                return null;
            }
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

    //**** VALIDATE TOKEN FUNCTION ****\\
    //validates if a token has expired or not, this function will automatically delete tokens that are past expiry
    public static function validate(String $token, String $type): bool
    {
        //create the outcome variable
        $outcome = false;
        //set the database for this validation, assumed the type is web by default
        $database = match ($type) {
            "game" => new tokens_game(),
            default => new tokens_web(),
        };
        //step 1 check if the token is in the database
        $result = $database->getRowByValue("token", $token);
        if($result != null){
            //next if it is a real token check the expiry
            if($result[self::$expiry] >= time()){
                $outcome = true;
            }else{
                $database->deleteRowByPK($result[self::$user_id]);
            }
        }

        return $outcome;
    }

    //**** DELETE TOKEN FUNCTION ****\\
    public static function delete(String $token, Table $database): bool{
        return $database->deleteRowByPK($token, $database);
    }

}