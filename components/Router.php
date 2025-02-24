<?php

class Router
{

    private $routes;
    private $status;


    public function __construct(){

        $this->routes = require_once(ROOT.'/config/routes.php');
        $this->status = false;


    }
    public function run(){

        $uri = $this->getUri();

        foreach($this->routes as $uriPattern=>$path){
            if(preg_match("~$uriPattern~", $uri)){

                $internalRouter = preg_replace("~$uriPattern~",$path,$uri);

                $segment =explode('/',$internalRouter);

                //print_r($segment);

                $controllerName = ucfirst(array_shift($segment)).'Controller';
                $actionName = 'action'.ucfirst(array_shift($segment));


                $controllerFile = ROOT.'/controllers/'.$controllerName.'.php';

                //echo $controllerFile;

                if(file_exists($controllerFile)){
                    include_once($controllerFile);

                    $controllerObject = new $controllerName;

                    $result = call_user_func_array(array($controllerObject, $actionName), $segment);

                    if($result != null){
                        $this->status = true;
                        break;
                    }
                }
            }
        }

        if(!$this->status){
            header('location:index');
        }
    }


    public function getUri(){
        if(!empty($_SERVER['REQUEST_URI'])){
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }


}