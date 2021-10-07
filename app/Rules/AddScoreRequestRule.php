<?php
/**
 * Copyright Jack Harris
 * Peninsula Interactive - CodeCrunchers
 * Last Updated - 5/10/2021
 */

namespace app\rules;

use app\core\Rule;

class AddScoreRequestRule extends Rule
{

    public function __construct()
    {
        $this->rules["user_id"] = ["required" => true];
        $this->rules["level"] = ["required" => true];
        $this->rules["score"] = ["required" => true];

        $this->databaseTable = "scores";
    }
}