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
            "password" => $request->getPostData()['password'],
            "registration_date" => time()
        ];

        //return the result of the database class
        return $users_db->createRow($values);
    }

}