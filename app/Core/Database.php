<?php
/**
 * Copyright Jack Harris
 * Peninsula Interactive - CodeCrunchers
 * Last Updated - 5/10/2021
 */

namespace app\core;

use mysqli;
use mysqli_result;

class Database
{
    //main database base connection method, used by the other facade functions
    private static function connect(): mysqli
    {
        return new mysqli("localhost","root","","codecrunchers");
    }

    public static function query($sql): mysqli_result|bool
    {
        return self::connect()->query($sql);
    }

    public static function fetch($sql): mysqli_result|array
    {
        return self::connect()->query($sql)->fetch_all();
    }


}