<?php
/**
 * Copyright Jack Harris
 * Peninsula Interactive - CodeCrunchers
 * Last Updated - 4/10/2021
 */

namespace app\rules;

use app\core\Rule;

//Extends the main Rule class
class SignupRequestRule extends Rule
{
    //constructor method is called when the object is created, our rules must be in here
    public function __construct()
    {
        //signup request rule, this is the rule that we use when validating our signup requests before storing the request in the database
        $this->rules["email"] = ["required" => true, "unique" => true];
        $this->rules["username"] = ["required" => true, "unique" => true];
        $this->rules["first_name"] = ["required" => true];
        $this->rules["last_name"] = ["required" => true];
        $this->rules["password"] = ["required" => true];
        //set the database table, used for unique check
        $this->databaseTable = "users";

    }

}