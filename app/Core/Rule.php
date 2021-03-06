<?php
/**
 * Copyright Jack Harris
 * Peninsula Interactive - CodeCrunchers
 * Last Updated - 4/10/2021
 */

namespace app\core;

abstract class Rule
{
    protected array $rules;
    protected String $databaseTable;

    //Abstract constructor for use by child rules
    public abstract function __construct();

    // PHP cannot return an array using the __toString method so json must be returned and then converted into an array
    public function __toString(): string
    {
        return json_encode($this->rules);
    }

    //getter for the database table name, used by the request class in validation
    public function getDatabaseTableName(): string
    {
        return $this->databaseTable;
    }
}