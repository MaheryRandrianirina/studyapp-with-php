<?php 
namespace App\Controllers;

use AltoRouter;
use App\App;

class LoginController extends FormController {
    public function __construct(AltoRouter $router)
    {
        parent::__construct();
        if($this->router === null){
            $this->router = $router;
        }
    }

    /**
     * login
     * rend la vue login
     * @param  mixed $params
     * @return void
     */
    public function loginPage($params = []):void
    {
        SessionController::setSessionStart();
        if($this->authorized()){
            $homecontroller = new HomeController($this->router);
            $homecontroller->indexForLogged();
        }else{
            $this->render("login", $params);
        }
        
    }

    public function loginForNotLogged()
    {
        SessionController::setSessionStart();
        $this->render("login");   
    }

    public function loginAction()
    {
        if($this->is_valid($_POST, "errors")){
            
            $app = App::getInstance();
            $usersmodel = $app->getModel("Users");

            $sanitizedPost = $this->sanitize($_POST);

            $user = $usersmodel->login($_POST);
            
            if(!empty($user)){
                $this->login($user, $_POST);
            }else{
                $this->redirect("loginpage", "loginUserNotFound", ['userNotFound' => "Utilisateur introuvable.\nVeuillez entrer des informations correctes."]);
            }
        }else{ 
            $this->redirect("loginpage", "login_errors", $this->errors());
            http_response_code(301);
        }
    }
    /**
     * login
     * crée la session de connexion
     * @param  mixed $user : peut être un tableau ou une instance de GlobalInterface
     * @param  mixed $posts
     * @return void
     */
    public function login($user, $posts = []): void
    {
        
        foreach($user as $userdata){
            
            if(password_verify($posts['pwd'], $userdata->getPassword())){

                if(isset($posts['remember-me']) || $posts['remember-me'] === true){
                    $cookieController = new CookiesController();
                    $cookieController->fromLogin($user);
                    
                }else{
                    SessionController::setSession("auth", $userdata->getId());
                }
                
                $this->redirect("homepage");
                http_response_code(301);

            }else{
                $this->redirect("loginpage", "uncorrect-password", ["pwd" => "Le mot de passe est incorrect"]);
                http_response_code(301);
            }
        }
        
        
    }
}