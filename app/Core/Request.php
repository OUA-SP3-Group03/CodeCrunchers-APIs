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

    public function __construct(){
    }

    public function setPostData($postData){
        $this->postData = $postData;
        Console::log(json_encode($postData));
    }
    public function setGetData($getData){
        $this->getData = $getData;
        Console::log(json_encode($getData));
    }
}