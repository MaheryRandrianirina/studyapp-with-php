<?php
namespace Database\Models;

use App\Controllers\SessionController;
use Core\InstancesHelpers\User;
use Core\Interfaces\GlobalInterface;
use Exception;

class UsersModel extends Model {
    /**
     * nom de la table
     */
    protected $table = "user";
    
    public function register($posts = [])
    {
        $this->posts = $posts;
        $fields = ["username", "mail", "birth", "country", "city", "sexe", "password"];
        
        if($this->insert($fields, ["registerBtn", "pwd-confirm"])){
            return $this->login($this->posts);
        }else{
            throw new Exception("Il y a eu une erreur d'enregistrement de l'utilisateur");
        }
    }
    
    /**
     * login
     * execute les requêtes pour la connexion de l'utilisateur
     * @param  mixed $posts
     * @return void
     */
    public function login($posts = [])
    {
        
        $this->posts = $posts;
        $userStatement = $this->select(["*"], ["username = ?"], ["username" => $this->posts['pseudo']]);

        if($userStatement !== null){
            $user = $this->fetch($userStatement, User::class, true);
            return $user;
        }else{
            return null;
        }
        
    }
    public function get(int $userid): ?GlobalInterface
    {
        $pdostatement = $this->select(['*'], ["id = ?"], ["id" => $userid]);
        
        if($pdostatement !== null){
            return $this->fetch($pdostatement, User::class);
        }else{
            return null;
        }
    }

    public static function profilePhoto(): ?string
    {
        //on récupère le path de la photo
        $filemodel = new FileModel();
        $image_path = $filemodel->getProfilePhotoPath();

        if($image_path !== null){
            $fullPath = dirname(__DIR__,2). DIRECTORY_SEPARATOR .  "data" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . $image_path->getPath();
            return $fullPath;
        }    
        return null;  
    }
}