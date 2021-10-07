<?php
/**
 * Copyright Jack Harris
 * Peninsula Interactive - CodeCrunchers
 * Last Updated - 6/10/2021
 */

namespace app\services;

use app\core\Service;

class CookieService extends Service
{

    //**** CREATE COOKIE STATIC METHOD ****\\
    public static function create(String $cookie_name, String $cookie_value, String $cookie_duration){
        //create a cookie with the values provided, time must be received in days
        //create the expiry time
        $expiry = time() + $cookie_duration * 24 * 60 * 60;
        //setcookie($cookie_name, $cookie_value,time() + $cookie_duration * 24 * 60 * 60,'/','localhost');

        $cookie_options = [
        'expires' => $expiry,
        'path' => '/',
            'secure' => false,
            'httponly' => false,
            'samesite' => "Lax",
        ];
        setcookie($cookie_name,$cookie_value,$cookie_options);
    }

    //**** DELETE COOKIE STATIC METHOD ****\\
    public static function delete(String $cookie_name){
        //delete cookie by setting its time to negative
        setcookie($cookie_name,"",time()-3600);
        //returns nothing
    }

}