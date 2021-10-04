<?php

use app\core\Gate;
use app\core\Request;
use app\providers\RouteServiceProvider;
use app\routes\Api;
use app\routes\Web;

/**
 * Copyright Jack Harris
 * Peninsula Interactive - CodeCrunchers
 * Last Updated - 4/10/2021
 */

class Application
{
    //**** SET CLASS VARIABLES ****\\
    private Request $request;
    private RouteServiceProvider $routeServiceProvider;

    //**** LOAD CLASS CONSTRUCTOR ****\\
    public function __construct()
    {
        //call create Request Method
        $this->createRequest();
        //create the route service provider
        $this->routeServiceProvider = new RouteServiceProvider($this->request);
        //add the routes from the API and Web files by creating a new instance of each of them
        new Web($this->routeServiceProvider);
        new Api($this->routeServiceProvider);

        $proccesedUrl = $this->processUrl();
        //firstly we check for a web or api call, if it's not the api then load the web else process the api
        if($proccesedUrl[0] != "/api") {
            //check if the response is a 404 if not then call the render function else display 404
            $result = $this->routeServiceProvider->loadRoute($proccesedUrl);
        }else{
            $apiUrl = array_slice($proccesedUrl,1,count($proccesedUrl)-1,);
            $result = $this->routeServiceProvider->loadApiRoute($apiUrl);
        }
        if (!$result) {
            echo Gate::getError(404);
            http_response_code(404);
        }
    }

    //**** PROCESS URL METHOD ****\\
    //converts the URL string into an array that is processed by the route service provide
    private function processUrl(){
        //create blank array, needed in the event no url is passed
        $url = [];
        $url = explode("/",$_SERVER['REQUEST_URI']);
           foreach ($url as $key => $item) {
               $url[$key] = "/".$item;
           }
        //returns the url array with the first value removed, this is important as we do not want to look at the first "/", it will default to 1  "/" regardless
        return array_slice($url,1,count($url)-1);
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