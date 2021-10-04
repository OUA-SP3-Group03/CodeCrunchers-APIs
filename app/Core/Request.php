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

    //**** GET POST DATA METHOD ****\\
    public function getPostData(){
        return $this->postData;
    }

    //**** SET POST DATA METHOD ****\\
    public function setPostData($postData){
        $this->postData = $postData;
    }

    //**** SET GET DATA METHOD ****\\
    public function setGetData($getData){
        $this->getData = $getData;
    }
}