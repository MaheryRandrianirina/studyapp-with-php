<?php
namespace App\Controllers;

class FormController extends Controller {
    public $posts = [];
    
    /**
     * Vérifie les erreurs des formulaires d'authentification
     */
    public function errors(): ?array
    {
        $errors = [];
        $posts = $this->posts;
        
        foreach($posts as $name => $post){
            if($name !== "submitBtn"){
                if(isset($posts[$name]) && empty($posts[$name])){
                    $errors[$name] = "Le champ {$name} est vide";  
                }
            }
        }

        if(isset($posts['pseudo']) && !preg_match("/[a-zA-Z_]/", $posts['pseudo'])){
            $errors["pseudo-syntax"] = "Pseudo invalide.";
        }
        if(isset($posts['pwd']) && !preg_match("/[a-zA-Z0-9_]/", $posts['pwd']) && strlen($posts['pwd']) < 8){
            $errors["pwd-syntax"] = "Mot de passe invalide.";
        }
        if(isset($posts['mail']) && !filter_var($posts['mail'], FILTER_VALIDATE_EMAIL)){
            $errors['mail'] = "Adresse mail invalide";
        }
        if(isset($posts['pwd-confirm']) && $posts['pwd'] !== $posts['pwd-confirm']){
            $errors["pwd-confirm"] = "Ce mot de passe ne correspond pas à l'original.";
        }
        
        if($errors !== null){
            return $errors;
        }
        return null;
        
        
    }

    public function calendarFormErrors(): ?array 
    {
        $errors = [];
        
        foreach($this->posts as $name => $post){
            if(!isset($this->posts[$name]) || empty($this->posts[$name])){
                $errors[$name] = "Ce champ est vide";
            }
        }
        
        if($errors !== null){
            return $errors;
        }

        return null;
        
    }
    /**
     * retourne si le contenu du formulaire est valide
     * @param string $errorMethod : le nom de la méthode à appeler
     */
    public function is_valid(array $posts, string $errorMethod): bool
    {
        $this->posts = $posts;
        return empty($this->$errorMethod());
    }
    
    /**
     * showErrors
     * affiche les erreurs de formulaire
     * @param  mixed $name : nom de l'erreur
     * @param  mixed $nameInArray : nom de l'erreur(clé) si c'est un tableau de tableau d'erreurs
     * @param  mixed $errors
     * @return string
     */
    public static function showErrors(?string $nameInArray = null, $errors = []): ?string
    {
        if($nameInArray !== null){
            if(isset($errors[$nameInArray])){
                return <<<HTML
                <p class="big-alert-danger">$errors[$nameInArray]</p>
HTML;            
            }
        }else{
            if(isset($errors)){
                return <<<HTML
                    <p class="alert-danger">$errors</p>
HTML;
            }
        }
        return null;
    }

    public function sanitize(array $posts = []): array
    {
        $sanitized_posts = [];
        foreach($posts as $name => $post){
            if($name !== "remember-me"){
                $sanitized_posts[$name] = htmlentities($post);
            }
            
            if($name === "pwd"){
                $sanitized_posts[$name] = password_hash($post, PASSWORD_BCRYPT);
            }
        }

        return $sanitized_posts;
    }

}