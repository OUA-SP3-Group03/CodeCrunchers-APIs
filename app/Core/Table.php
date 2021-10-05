<?php
/**
 * Copyright Jack Harris
 * Peninsula Interactive - CodeCrunchers
 * Last Updated - 5/10/2021
 */

namespace app\core;

use mysqli_result;

abstract class Table
{

    //protected variables to correlate to the data in the database
    protected String $tableName;
    protected String $primaryKey;
    protected array $columns;

    //Abstract constructor to force child classes to create it
    public abstract function __construct();

    //get table name
    public function getTableName(): string
    {
        return $this->tableName;
    }

    //gets the primary key of this table
    public function getPrimaryKey():String
    {
        return $this->primaryKey;
    }

    //get all rows from the table, turns array
    public function getAllRows():array
    {
        return Database::fetch("SELECT * FROM $this->tableName");
    }

    //gets the row with a matching primary key
    public function getRowByPK($value): mysqli_result|array
    {
        //returns the [0] index as currently mysql will return an array with in an array, this removes the outer array
        return Database::fetch("SELECT * FROM $this->tableName WHERE $this->primaryKey='$value'")[0];
    }

    //gets a row by a specific column value name, accepts column name and value
    public function getRowByValue(String $column, String $value): ?array{
        //step 1 check if the request column is in the array
        if(in_array($column, $this->columns)) {
            //perform the database request and save the result in the result variable
            $result =  Database::fetch("SELECT * FROM $this->tableName WHERE $column='$value'");
            //if the result failed it will be null, we simply check if it is not null and return it if so, else return an error
            if($result != null){
                return $result[0];
            }else{
                //if it failed return the value does not exist error
                return null;
            }
        }
        //else if the column does not exist return column not found error
        return null;
    }

    //create a row in the table
    public function createRow(array $values): array
    {

        //step 1 check to see if all the columns are provided
        $result = [];
            foreach ($this->columns as $column){

                if(!array_key_exists($column,$values)){
                    $result[$column] = "missing";
                }
            }

            if($result == []){
                $result["status"]="success";
            }
            return $result;
        }


}