<?php
/**
 * Copyright Jack Harris
 * Peninsula Interactive - CodeCrunchers
 * Last Updated - 4/10/2021
 */

namespace app\core;

class Gate
{
    //method function restricts specific controllers or sub controllers from being accessed by specific method types
    public static function post(): ?int
    {
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            return null;
        }
        http_response_code(405);
        return 405;
    }
    public static function get(): ?int{
        if($_SERVER['REQUEST_METHOD'] == "GET"){
            return null;
        }
        http_response_code(405);
        return 405;
    }

    //Gate get error data from code
    public static function getError($code): string
    {
        return match ($code) {
            405 => "405: The request method is not supported for the requested resource",
            404 => "404: The requested resource could not be found",
            default => "invalid error code",
        };
    }

}