<?php
namespace Core\Helpers;

use App\Controllers\CookiesController;
use App\Controllers\SessionController;

class User {
    public static function getId()
    {
        SessionController::setSessionStart();
        
        if(isset($_COOKIE['auth']) && !empty($_COOKIE['auth'])){
            return (int)CookiesController::getUserId();
        }elseif(isset(($_SESSION['auth'])) && !empty($_SESSION['auth'])){
            return (int)$_SESSION['auth'];
        }
        
    }
}