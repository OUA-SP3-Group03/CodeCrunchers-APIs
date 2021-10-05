<?php
/**
 * Copyright Jack Harris
 * Peninsula Interactive - CodeCrunchers
 * Last Updated - 5/10/2021
 */

namespace app\database;

use app\core\Table;

class users extends Table
{

    //implementation of the abstract constructor
    public function __construct()
    {
        //set the table name, primary key and columns
        $this->tableName = "users";
        $this->primaryKey = "user_id";
        //columns are used to validate query's before they are sent off to my SQL, columns must match the column names in SQL
        $this->columns = ["user_id","user_name","first_name","last_name","email","password","registration_date"];
    }
}