<?php

use app\core\Console;
use app\core\Request;

/**
 * Copyright Jack Harris
 * Peninsula Interactive - CodeCrunchers
 * Last Updated - 4/10/2021
 */

class Application
{
    //**** SET CLASS VARIABLES ****\\
    private Request $request;

    //**** LOAD CLASS CONSTRUCTOR ****\\
    public function __construct()
    {
    //call create Request Method;
    $this->createRequest();
    }

    //**** CREATE REQUEST METHOD ****\\
    //creates the request used by controllers and other classes
    private function createRequest(){
        //**** CREATE REQUEST **** \\
        $this->request = new Request();
        //first check if we have post data to add to the request, if so add it, else skip and pass blank array
        $postData = [];
        if(isset($_POST)){
            foreach ($_POST as $key => $data){
                $postData[$key] = $data;
            }
        }
        $this->request->setPostData($postData);
        //now check for get data to and add it to the request
        $getData = [];
        if(isset($_GET)){
            foreach ($_GET as $key => $data){
                $getData[$key] = $data;
            }
        }
        $this->request->setGetData($getData);
    }


}