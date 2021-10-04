<?php
/**
 * Copyright Jack Harris
 * Peninsula Interactive - CodeCrunchers
 * Last Updated - 4/10/2021
 */

namespace app\core;

class Console
{

    //Console log pass over from PHP to Javascript
    public static function log($value){
        if($_SERVER['REQUEST_METHOD'] != "POST") {
            echo "<script>console.log('$value');</script>";
        }else{
            echo $value."\n";
        }

    }

}