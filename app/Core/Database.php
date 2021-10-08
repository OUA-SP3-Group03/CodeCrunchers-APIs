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
    const affectedRows = 0;

    //main database base connection method, used by the other facade functions
    private static function connect(): mysqli
    {
        return new mysqli("localhost","root","","codecrunchers");
    }

    public static function query($sql, Table $callback = null): mysqli_result|bool
    {
        $database = self::connect();
        $result = $database->query($sql);
        $callback?->setAffectedRows($database->affected_rows);
        return $result;
    }

    public static function fetch($sql): mysqli_result|array
    {
        return self::connect()->query($sql)->fetch_all();
    }


}