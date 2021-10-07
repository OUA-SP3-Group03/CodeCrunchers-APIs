<?php
/**
 * Copyright Jack Harris
 * Peninsula Interactive - CodeCrunchers
 * Last Updated - 6/10/2021
 */

namespace app\database;

use app\core\Table;

class tokens_web extends Table
{

    public function __construct()
    {
        $this->tableName = "tokens_web";
        $this->primaryKey = "token";
        $this->columns = ["user_id","token","expiry"];
    }
}