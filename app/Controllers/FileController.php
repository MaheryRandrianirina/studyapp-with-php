<?php
namespace App\Controllers;

use App\App;
use Core\Helpers\User;
use Core\InstancesHelpers\Image;
use Exception;

class FileController extends Controller {
    public $uploadfile;

    /**
     * store
     * enregistre le fichier dans un dossier particulier qu'aucun utilisateur n'ait accès
     * et retourne le nouveau path afin de l'enregistrer dans la BD
     * @param  mixed $file
     * @return void
     */
    public function store($file, $dir): bool
    {
        $this->uploadfile = $dir . basename($file['name']);
        
        if(move_uploaded_file($file['tmp_name'], $this->uploadfile)){
            $filemodel = App::getInstance()->getModel("File");
            $filedata = [
                "path" => explode("D:\\CODES\\MES PROJETS\\APPLICATION D'ETUDE\\data\\images\\",$this->uploadfile)[1],
                "extension" => explode("/", $file['type'])[1],
                "size" => (int)$file['size'],
                "user_id" => (int)User::getId()
            ];
            
            $image_path = $filemodel->getProfilePhotoPath();
            if($image_path === null){
                if($filemodel->insert(["path", "extension", "size", "user_id"], $filedata)){
                    return true;
                }else{
                    throw new Exception("Il a eu erreur lors du remplissage de la table user_images");
                }
            }else{  
                if($filemodel->update(["path=?", "extension=?", "size=?", "user_id=?"], $filedata, [
                    "where" => ["user_id = " =>  User::getId()]
                ])){
                    return true;
                }else{
                    return false;
                }
                //SI L'IMAGE EXISTE DEJA, ON DOIT EFFACER L'IMAGE EXISTANT DANS LE DOSSIER LA CONTENANT
            }      
        }else{
            return false;
        }
    }
}