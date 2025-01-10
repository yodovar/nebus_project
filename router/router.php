<?php
            require_once "../nebus_project/controllers/api.php";
    Class Router{

    public $routes;

    public function __construct()
    {
       $routesPath = ROOT."/app/helpers/routes.php";
       return $this->routes = include_once($routesPath);
    //    echo $routesPath;
    }
    
    private function getUri(){
        if(!empty($_SERVER['REQUEST_URI']))
          
            $s_uri = str_replace('/nebus_project/router/', '', $_SERVER['REQUEST_URI']);
        

        return trim($s_uri);
    }

    public function run(){
        $uri = $this->getUri();

        foreach($this->routes as $uriPattern => $path){
            if (preg_match("~$uriPattern~","$uri")){
                $segments = explode('/', $path);
                $controllerName = array_shift($segments)."Controller";
                $actionName = "action".ucfirst(array_shift($segments));
                
                $fileName  = ROOT."/controllers/".$controllerName.'.php';
                if(file_exists($fileName)){
                    include_once($fileName);
                }
                $objectController = new $controllerName;
                $result = method_exists($objectController, $actionName) ? $objectController->$actionName() : null;
                exit;
                if ($result != NULL){
                    break;
                }
            }
        }
    }

}