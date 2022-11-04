<?php
namespace App;

use AltoRouter;
use Exception;

class Router {
    private $router;
    public $action = [];

    public function __construct()
    {
        $this->router = new AltoRouter(); 
    }

    public function get(string $url, string $view, string $action, ?string $name = null)
    {
        $this->action[$view] = $action;
        $this->router->map("GET", $url, $view, $name);

        return $this;
    }

    public function post(string $url, string $target, string $action, ?string $name = null)
    {
        $this->action[$target] = $action;
        $this->router->map("POST", $url, $target, $name);

        return $this;
    }

    public function run()
    {
        $match = $this->router->match();
        
        if($match !== false){
            $view = $match['target'];
            $action = explode("@", $this->action[$view]);
            $controller = new $action[0]($this->router); 
            $method = $action[1];
            $controller->$method($match['params']);
        }else{
            throw new Exception("L'url n'existe pas");
            http_response_code(404);
        }

        return $this;
    }

}