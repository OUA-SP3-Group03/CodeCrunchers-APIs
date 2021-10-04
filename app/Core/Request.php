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
                        if(!$this->unique($this->postData[$key])){
                            $this->errors[$ruleSingleKey] = "Unique validation failed";
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
    private function unique(String $value): bool
    {
        //TODO add code later when ORM is complete
        return true;
    }

    //**** EMAIL CONSTRAIN FUNCTION ****\\
    //uses PHP built-in function to check if an email meets the requirements of being an email
    private function email(String $value){
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
}