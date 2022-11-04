<?php
namespace App\Controllers;

use App\App;

class CookiesController extends Controller {    
    /**
     * fromLogin
     * crée une cookie après le login si remeber-me a été coché.
     * @param  mixed $user
     * @param  mixed $posts
     * @return void
     */
    public function fromLogin($user = [], $posts = []): void
    {
        foreach($user as $userdata){
            //la dernière valeur de setcookie "true" permet de faire en sorte que la cookie ne soit pas manipulable par JS.
            setcookie("auth", $userdata->getId() . "----" . sha1($userdata->getUsername() . $userdata->getPassword()), time() + 3600 * 24 * 7, "/", "localhost", false, true);
        }
        
    }    
    /**
     * auth
     * vérifie que l'utilisateur dans le cookie existe
     * @param  mixed $authCookie
     * @return bool
     */
    public static function auth($authCookie): bool
    {
        $explode = explode("----", $authCookie);
        $userid = (int)$explode[0];
        
        $usersmodel = App::getInstance()->getModel("Users");
        $user = $usersmodel->get($userid);
        
        if(sha1($user->getUsername() . $user->getPassword()) === $explode[1]){
            return true;
        }else{
            return false;
        }
             
    }

    public static function getUserId()
    {
        $user_id = explode('----', $_COOKIE['auth'])[0];
        return $user_id;
    }
}