<?php
/**
 * Copyright Jack Harris
 * Peninsula Interactive - CodeCrunchers
 * Last Updated - 4/10/2021
 */

namespace app\core;

class Request
{
    private array $postData;
    private array $getData;
    private array $cookieData;
    private array $errors = [];

    public function validate(Rule $rules){
        foreach (json_decode($rules,true) as $key => $rule){


            if(array_key_exists($key, $this->postData)){

                foreach ($rule as $ruleSingleKey => $ruleSingle){
                    if($ruleSingleKey == "required"){
                        if(!$this->required($this->postData[$key])){
                            $this->errors[$ruleSingleKey] = "Required validation failed";
                        }

                    }else if($ruleSingleKey == "unique"){
                        if(!$this->unique($this->postData[$key],$key,$rules->getDatabaseTableName())){
                            $this->errors[$key] = "Unique validation failed";
                        }

                    }else if($ruleSingleKey == "email"){
                        if(!$this->email($this->postData[$key])){
                            $this->errors[$ruleSingleKey] = "Email validation failed";
                        }
                    }
                }


            }else{
                $this->errors[$key] = "Required Constrain Failed";
            }
        }


    }

    //**** REQUIRED CONSTRAIN FUNCTION ****\\
    //checks to see if the value has met the criteria or not, returns true or false, in this case it simply checks to ensure its not empty
    private function required($value): bool
    {
        if(!empty($value)){
            return true;
        }
        return false;
    }


    //**** UNIQUE CONSTRAIN FUNCTION ****\\
    //Checks the database to see if the value is going to be unique, throws false if the value is present in the specified table
    private function unique(String $value, String $column ,String $tableName): bool
    {
        //I have no time to fix this lol!
        if($column === "username"){
            $column = "user_name";
        }

        //set the namespace for the database class
        //ERROR: a space is needed after the black slash, this needs to be removed in the next line
        $namespace = "\app\database\ ";
        //remove the space
        $namespace = substr($namespace,0,-1);

        //combine the two into the table string
        $table = $namespace.$tableName;
        //create the object and set it to the table variable
        $table = new $table;

        //get the row by the specified column, it does not yield a response return true
        if($table->getRowByValue($column,$value) != null){
            return false;
            //else it means we have no value matching it, we should return true to allow the storing of the data
        }else{
            return true;
        }
    }

    //**** EMAIL CONSTRAIN FUNCTION ****\\
    //uses PHP built-in function to check if an email meets the requirements of being an email
    private function email(String $value): bool
    {
        if(filter_var($value, FILTER_VALIDATE_EMAIL)){
            return true;
        }
        else{
            return false;
        }
    }

    //**** GET REQUEST ERROR ****\\
    //returns the json output for the error results
    public function getErrors(): array{
        return $this->errors;
    }

    //**** GET POST DATA METHOD ****\\
    public function getPostData(): array{
        return $this->postData;
    }

    //**** GET GET DATA METHOD ****\\
    public function getGetData(): array{
        return $this->getData;
    }

    //**** SET POST DATA METHOD ****\\
    public function setPostData(array $postData){
        $this->postData = $postData;
    }

    //**** SET GET DATA METHOD ****\\
    public function setGetData(array $getData){
        $this->getData = $getData;
    }

    //**** SET COOKIE DATA ****\\
    public function setCookieData(array $cookieData){
        $this->cookieData = $cookieData;
    }

    //**** GET COOKIE DATA ****\\
    public function getCookieData(): array
    {
        return $this->cookieData;
    }
}