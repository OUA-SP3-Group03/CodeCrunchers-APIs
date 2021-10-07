<?php
/**
 * Copyright Jack Harris
 * Peninsula Interactive - CodeCrunchers
 * Last Updated - 4/10/2021
 */

namespace app\core;

use app\services\TokenService;

class Gate
{
    //method function restricts specific controllers or sub controllers from being accessed by specific method types
    public static function post(): ?int
    {
        if($_SERVER['REQUEST_METHOD'] == "POST"){
           return true;
        }else{
            return false;
        }
    }
    public static function get(): ?int{
        if($_SERVER['REQUEST_METHOD'] == "GET"){
            return true;
        }else{
            return false;
        }
    }

    //Gate logged in only
    public static function loggedIn(): bool
    {
        if(isset($_COOKIE["codecrunchers"]) && TokenService::validate($_COOKIE["codecrunchers"],"web")){
            return true;
        }else {
            return false;
        }

    }

    public static function echo($responseCode){
        http_response_code($responseCode);
        echo match ($responseCode) {
            405 => "405: The request method is not supported for the requested resource",
            404 => "404: The requested resource could not be found",
            403 => "403: The requested resource could not be loaded as you have insufficient permission",
            default => "invalid error code",
        };
    }

    public static function redirect(String $location){
        ob_start();
        header("location: $location");
        ob_flush();
    }

}