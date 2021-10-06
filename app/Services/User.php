<?php
/**
 * Copyright Jack Harris
 * Peninsula Interactive - CodeCrunchers
 * Last Updated - 6/10/2021
 */

namespace app\services;

use app\core\Request;
use app\core\Service;
use app\database\users;

class User extends Service
{
    //variable mapping
    //password map var is private as no other methods should call it
    private static int $password = 5;
    //public accessible array mappings
    public static int $user_id = 1;
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

}