<?php
/**
 * Copyright Jack Harris
 * Peninsula Interactive - CodeCrunchers
 * Last Updated - 6/10/2021
 */

namespace app\database;

use app\core\Table;

class tokens_game extends Table
{

    public function __construct()
    {
        $this->tableName = "tokens_game";
        $this->primaryKey = "user_id";
        $this->columns = ["user_id","token","expiry"];
    }
}