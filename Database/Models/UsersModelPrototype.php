<?php
namespace Database\Models;

use App\Controllers\SessionController;
use Core\InstancesHelpers\User;
use Exception;

class UsersModel extends Model {
    public $table = "user";
    
    public function __construct($request = [])
    {
        if($this->posts === null){
            $this->posts = $request;
        }
        
    }
    public function register()
    {
        $fields = ["username", "mail", "birth", "country", "city", "sexe", "password"];
        
        if($this->insert($fields, ["registerBtn", "pwd-confirm"])){
            return $this->login();
        }else{
            throw new Exception("Il y a eu une erreur d'enregistrement de l'utilisateur");
        }
    }
    
    /**
     * login
     * execute les requêtes pour la connexion de l'utilisateur.
     * @param  mixed $posts
     * @return void
     */
    public function login()
    {
        
        $userStatement = $this->select(["*"], ["username = ?"], ["username" => $this->posts['pseudo']]);

        if($userStatement !== null){
            $user = $this->fetch($userStatement, User::class, true);
            return $user;
        }else{
            return null;
        }

        
    }
}