<?php
namespace Core\Helpers;

class ImageHelper {

    public static function displayImage(string $path)
    {
        $diaplayProfilePhoto = dirname(__DIR__,2) . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . "display-profile-photo.php";
        
        if(file_exists($path)){
            $filecontent = file_get_contents(dirname(__DIR__,2) . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . "profile-photo.php");
            $replaced = substr_replace($filecontent, $path, 30, -2);
            if(is_writable($diaplayProfilePhoto)){
                if(!$handle = fopen($diaplayProfilePhoto, 'a')){
                    dd("Impossible d'ouvrir le fichier");
                    exit();
                }

                if(fwrite($handle, $replaced) == FALSE){
                    dd("Impossible d'écrire dans le fichier");
                    exit();
                }
                dd('ecriture réussi');
                fclose($handle);
            }else{
                dd("Le fichier $diaplayProfilePhoto n'est pas accessible en écriture");
            }
        }else{
            var_dump('Le fichier n\'existe pas');
        }
    }
}