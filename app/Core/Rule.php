<?php
/**
 * Copyright Jack Harris
 * Peninsula Interactive - CodeCrunchers
 * Last Updated - 4/10/2021
 */

namespace app\core;

class Rule
{
    protected array $rules;

    // PHP cannot return an array using the __toString method so json must be returned and then converted into an array
    public function __toString(): string
    {
        return json_encode($this->rules);
    }
}