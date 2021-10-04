<?php
/**
 * Copyright Jack Harris
 * Peninsula Interactive - CodeCrunchers
 * Last Updated - 4/10/2021
 */

namespace app\rules;

use app\core\Rule;

class LoginRequestRule extends Rule
{

    public function __construct()
    {
        $this->rules["email"] = ["required" => true,"unique" => true, "email" => true];
        $this->rules["name"] = ["required" => true];
    }

}