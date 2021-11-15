<?php
/**
 * Copyright Jack Harris
 * Peninsula Interactive - CodeCrunchers
 * Last Updated - 4/10/2021
 */

namespace app\rules;

use app\core\Rule;

//Extends the main Rule class
class GetRequestRule extends Rule
{
    //constructor method is called when the object is created, our rules must be in here
    public function __construct()
    {
        //login request rule, this is the rule that validates our login request using this criteria
        $this->rules["token"] = ["required" => true];
        $this->rules["type"] = ["required" => true];

        //set the database table
        $this->databaseTable = "tokens_web";
    }

}