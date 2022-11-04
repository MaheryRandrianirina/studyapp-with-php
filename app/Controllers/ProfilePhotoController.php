<?php
namespace App\Controllers;

class ProfilePhotoController extends Controller {
    public function action()
    {   
        if(isset($_FILES['profilePhoto']) && !empty($_FILES['profilePhoto'])){
            $filedir =  dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "data" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "users/";
            $fileController = new FileController();
            
            if($fileController->store($_FILES['profilePhoto'], $filedir)){
                echo json_encode(["success" => "Fichier téléchargé avec succès."]);
            }else{
                echo json_encode(["fail" => "Le téléchargement du fichier a échoué."]);
            }
        }else{
            echo "fichier non reçu";
            http_response_code(404);
        }
    }
}