<?php
namespace App\Controllers;

use App\App;
use Core\Helpers\MyDateTime;
use Core\Helpers\User;
use Core\InstancesHelpers\Emploidutemps;
use DateTime;
use DateTimeZone;
use Exception;

class UserController extends Controller {
    public function calendar()
    {
        $formcontroller = new FormController();
        if($formcontroller->is_valid($_POST, "calendarFormErrors")){
            $sanitizedPosts = $formcontroller->sanitize($_POST);
            $app = App::getInstance();
            //on insert l'emploi du temps
            $emploi_du_temps = $app->getModel('Calendar');
            $user_id = User::getId();
            $model = $app->getModel();
            $model->beginTransaction();

            if($emploi_du_temps->insert(['user_id'], ['user_id' => $user_id])){
                $statement = $emploi_du_temps->select(['id']);
                $ids = $emploi_du_temps->fetch($statement, Emploidutemps::class, true);
                $last_id = (int)end($ids)->getId();
                
                $chunkedSanitizedPosts = array_chunk($sanitizedPosts, 4, true); 
                //peut importe la taille du tableau, le dernier element est toujours l'id de l'emploi du temps 
                $chunkedSanitizedPosts[] = $last_id;
                //on enlève 1 la taille du tableau car le nombre de tableaux dedans sera utilisé pour le nombre de requête
                $number_for_loop = count($chunkedSanitizedPosts) - 1;

                $emploi_du_temps_content_model = $app->getModel('Emploidutempscontent');
                $success = null;
                $myDateTime = new MyDateTime();
                
                for($i = 0; $i < $number_for_loop; $i++){
                    
                    $date = $chunkedSanitizedPosts[$i]['date-'. $i + 1];
                    $time = $chunkedSanitizedPosts[$i]['hour-'. $i + 1];
                    
                    //timestamp of the date and time (complete)
                    $timestamp = $myDateTime->getTimeStamp($date, $time);
                    //timestamp of the date
                    $datetimestamp = $myDateTime->getTimeStamp($date);
                    $myDateTime->getDate($datetimestamp);

                    foreach($chunkedSanitizedPosts[$i] as $name => $value){
                        if($name === "date-".$i+1 || $name === "hour-".$i+1){
                            array_pop($chunkedSanitizedPosts[$i]);
                        }
                    }

                    //push into the array the timestamp of the subject
                    $chunkedSanitizedPosts[$i]['date-'.$i+1] = $datetimestamp;
                    $chunkedSanitizedPosts[$i]['hour-'.$i+1] = $timestamp;
                    
                    if($emploi_du_temps_content_model->insert(['subject', 'chapter', 'date', 'time', 'emploi_du_temps_id'], [$chunkedSanitizedPosts[$i], [end($chunkedSanitizedPosts)]])){
                        //FAIRE UNE INSERTION DANS emploi_du_temps_day
                        $calendarDay = $app->getModel("CalendarDay");
                        
                        
                        if($calendarDay->insert(['calendar_timestamp', 'emploi_du_temps_id', 'user_id'], [
                            'timestamp' => $datetimestamp,
                            'id' => $last_id, 
                            'user_id' => $user_id
                            ])){
                            $success = 1;
                        }else{
                            $success = 0;
                        }
                    }else{
                        $success = 0;
                    }

                }

                if($success === 1){
                    echo json_encode(['success' => 'Nouvel emploi du temps créé']);
                }elseif($success === 0){
                    echo json_encode(['fail' => 'Un problème est survenu lors de la création de l\'emploi du temps.']);
                }
                
            }else{
                echo json_encode(['fail' => "création de l'emploi du temps échouée. Veuillez reéssayer"]);
            }
            $model->commit();
        }else{
            echo json_encode(['fail' => "Le formulaire est invalide"]);
            die();
            //On rédirige vers l'ajout d'emploi du temps(il faudra gérer les params dans l'url
            // car nous allons ajouter un param à l'url de redirection)
        }
    }
}