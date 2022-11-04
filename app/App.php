<?php
namespace App;

use Database\Database;

class App {
    
    public static $_instance;

    public static function getInstance(): App
    {
        if(self::$_instance === null){
            self::$_instance = new App();
        }

        return self::$_instance;
    }
    
    /**
     * récupère le model précisé dans le paramètre.
     * si le paramètre est vide, récupère le model parent
     * @param String $name = null
     * @return Model
     */
    public function getModel(?string $name = null)
    {
        $model = null;
        
        if($name !== null){
            $model = "Database\\Models\\" . ucfirst($name) . "Model";
        }else{
            $model = "Database\\Models\\Model";
        }
        
        return new $model();
    }
}
