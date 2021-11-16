<?php
/**
 * Copyright Jack Harris
 * Peninsula Interactive - CodeCrunchers
 * Last Updated - 6/10/2021
 */

namespace app\services;

use app\core\Console;
use app\core\Request;
use app\core\Service;
use app\database\tokens_game;
use app\database\tokens_web;
use app\database\users;

class UserService extends Service
{
    //variable mapping
    //password map var is private as no other methods should call it
    private static int $password = 5;
    //public accessible array mappings
    public static int $user_id = 0;
    public static int $username = 1;
    public static int $first_name = 2;
    public static int $last_name = 3;
    public static int $email = 4;


    //**** CREATE USER FUNCTION ****\\
    public static function create(Request $request): bool
    {
        //create instance of the users' database table
        $users_db = new users();
        //generate the first user id
        $user_id = rand(0,10**6);

        //check that that id is available, if not regenerate until we get an unused one
        while($users_db->getRowByPK($user_id)  != null){
            //try a new random number
            $user_id = rand(0,10**6);
        }

        //create the array of values to be sent to the database class
        $values = [
            "user_id" => $user_id,
            "user_name" => $request->getPostData()['username'],
            "first_name" => $request->getPostData()['first_name'],
            "last_name" => $request->getPostData()['last_name'],
            "email" => $request->getPostData()['email'],
            "password" => password_hash($request->getPostData()['password'],PASSWORD_DEFAULT),
            "registration_date" => time()
        ];

        //return the result of the database class
        return $users_db->createRow($values);
    }

    //**** LOGIN USER METHOD ****\\
    public static function login(Request $request): ?array
    {
        //create instance of the user table
        $user_db = new users();
        //try getting a user from the table based on the email provided, save the result as $result
        $result = $user_db->getRowByValue("email", $request->getPostData()["email"]);
        //check if the result is not null, if its null it failed, else it has a result
        if($result != null){
            //now check if the password provided matches the password we have on file, if so success is represented as 0
            if(password_verify($request->getPostData()["password"],$result[self::$password])){
                //finally, return the result if valid
                return $result;
            }
        }
            //returns null if no login succeeds
            return null;
    }

    //**** LOGOUT USER METHOD FOR WEB ****\\
    public static function logoutWeb(String $token): bool
    {
        CookieService::delete("codecrunchers");
        return TokenService::delete($token, new tokens_web());
    }

    //**** LOGOUT USER METHOD FOR GAME ****\\
    public static function logoutGame(String $token):bool
    {
        $database =  new tokens_game();
        $result =  TokenService::delete($token,$database);

        if($result && $database->getAffectedRows()>0){
            return true;
        }
        return false;
    }

    //**** CHECK USER TOKEN FOR WEB ****\\
    public static function checkWeb(String $token): bool
    {
        return TokenService::validate($token,"web");
    }

    //**** CHECK USER TOKEN FOR Game ****\\
    public static function checkGame(String $token): bool
    {
        return TokenService::validate($token,"game");
    }

    public static function getInfo(String $token): array
    {
        $game_db = new tokens_game();
        $user_id = $game_db->getRowByValue("token",$token);
        if($user_id != null) {
            $user_id = $user_id[0];
        }
        $user_db = new users();
        $result = $user_db->getRowByPK($user_id);
        if($result != []){
            return $result;
        }else{
            return [];
        }
    }

    public static function getInfoWeb(String $token): array
    {
        $token_db = new tokens_web();
        $user_id = $token_db->getRowByValue("token",$token);
        if($user_id != null) {
            $user_id = $user_id[0];
        }
        $user_db = new users();
        $result = $user_db->getRowByPK($user_id);
        if($result != []){
            return $result;
        }else{
            return [];
        }
    }

    public static function getUsername(int $userId = null){
        $user_db = new users();
        $outcome = null;

        $result = $user_db->getRowByPK($userId);
        if($result != null || $result != []){
            $outcome = $result[1];
        }

        return $outcome;
    }



}