<?php
namespace App\Controllers;

class SessionController extends Controller {
    public static function setSessionStart()
    {
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }
    }

    public static function setSession(string $name, ?int $value = null, array $values = [])
    {
        self::setSessionStart();
        
        if($value !== null){
            $_SESSION[$name] = $value;
        }elseif($values !== null){
            $_SESSION[$name] = $values;
        }
        
    }
}