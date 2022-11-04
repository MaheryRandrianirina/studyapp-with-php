<?php
namespace App\Controllers;

use AltoRouter;
use App\App;
use FilesystemIterator;

class Controller {
    protected $router;
    private $filedir;
    protected $app;
    public function __construct()
    {
        $this->app = App::getInstance();

    }
        
    /**
     * render
     * rend la vue passé en paramètre
     * @param  mixed $view
     * @param  mixed $params
     * @return void
     */
    public function render(string $view, $params = [], ?string $profilePhoto = null)
    {
        $router = $this->router;
        $profilePhoto = $profilePhoto;
        $params = $params;
        $view = str_replace(".", "/", $view);
        ob_start();
        require dirname(__DIR__,2) . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . $view . ".php";
        $content = ob_get_clean();
        require dirname(__DIR__,2) . DIRECTORY_SEPARATOR . "views/layouts/default.php";
    }
    
    /**
     * renderWithoutLayout
     * retourne la vue sans le layout
     * @param  mixed $view
     * @param mixed $db_select : résultat d'un select à envoyer à la view
     * @param  mixed $params
     * @return void
     */
    public function renderWithoutLayout(string $view, mixed $db_select = [], $params = [])
    {
        $router = $this->router;
        $params = $params;
        $results = $db_select;
        $view = str_replace(".", "/", $view);
        require dirname(__DIR__,2) . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . $view . ".php";
    }
    
    public function redirect(string $routeName, string $error_name = null, array $errors = [])
    {
        if(!empty($errors) && $error_name !== null){
            //SessionController : à repenser
            //mettre les erreurs dans une session
            SessionController::setSession($error_name, null, $errors);
        }
        $route = $this->router->generate($routeName);
        
        header("Location:$route");
    }
      
    /**
     * authorized
     * gère les autorisations
     * @return bool
     */
    public function authorized(): bool
    {
        if(isset($_COOKIE['auth']) && !empty($_COOKIE['auth'])){
            
            if(CookiesController::auth($_COOKIE['auth'])){
                return true;
            }else{
                return false;
            }
        }elseif(isset($_SESSION['auth']) && !empty($_SESSION['auth'])){
            return true;
            
        }else{
            return false;
        }
    }          
}