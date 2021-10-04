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

    public function validate(Rule $rule){
    //TODO add validate functionality
    }

    public function setPostData($postData){
        $this->postData = $postData;
    }
    public function setGetData($getData){
        $this->getData = $getData;
    }
}