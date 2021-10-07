<?php
/**
 * Copyright Jack Harris
 * Peninsula Interactive - CodeCrunchers
 * Last Updated - 5/10/2021
 */

namespace app\database;

use app\core\Table;

class scores extends Table
{

    public function __construct()
    {
        //set the table name, primary key and columns
        $this->tableName = "scores";
        $this->primaryKey = "id";
        //columns are used to validate query's before they are sent off to my SQL, columns must match the column names in SQL
        $this->columns = ["id","user_id","time_stamp","score","level"];
    }

}