<?php
namespace App\Controllers;

use AltoRouter;

class LogoutController extends Controller {
    public function __construct(AltoRouter $router)
    {
        parent::__construct();
        if($this->router === null){
            $this->router = $router;
        }
    }
    public function logout($params = [])
    {
        SessionController::setSessionStart();

        if(isset($_SESSION['auth'])){
            session_unset();
        }elseif(isset($_COOKIE['auth'])){
            setcookie("auth", "destroy-cookie", time() - 3600, "/", "localhost", false, true);
        }

        $this->redirect('loginpage');
    }
}