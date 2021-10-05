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
    public function getRowByPK($value)
    {
        //returns the [0] index as currently mysql will return an array with in an array, this removes the outer array
        $result = Database::fetch("SELECT * FROM $this->tableName WHERE $this->primaryKey='$value'");
        if($result != null) {
            return $result[0];
        }else{
            return false;
        }
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
    public function createRow(array $values): bool
    {

        //step 1 check to see if all the columns are provided
        $result = true;
            foreach ($this->columns as $column){

                if(!array_key_exists($column,$values)){
                   $result = false;
                }
            }

            //if the result has no missing columns then proceed to creating the sql query
            if($result){
                //step 1 we create the start of the columns and new values array with the opening bracket
                $columns = "(";
                $newValues = "(";
                //next we loop over our columns and new values and add them to the string seperated by commas
                foreach ($values as $column=>$value){
                    $columns.=$column.",";
                    $newValues.="'".$value."',";
                }
                //finally, we trim the final spare comma of each of the strings
                $newValues = substr($newValues,0,-1);
                $columns = substr($columns,0,-1);
                //next we close the final bracket and add the two strings to the sql query
                $columns.=")";
                $newValues.=")";

                //build query
                $sql = "INSERT INTO $this->tableName ".$columns."VALUES".$newValues;

                //check if it succeeded or failed
                if(Database::query($sql)){
                    $result = true;
                }else{
                    $result = false;
                }

            }
            //finally, return the result
            return $result;
        }


}