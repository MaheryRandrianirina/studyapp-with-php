<?php
namespace App\Controllers;
require dirname(__DIR__,2) . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";
use AltoRouter;
use Core\Helpers\ImageHelper;
use Core\Helpers\MyDateTime;
use Core\Helpers\User;
use Core\InstancesHelpers\Calendar;
use Core\InstancesHelpers\Calendarcontent;
use Database\Models\UsersModel;

class HomeController extends Controller {
    public function __construct(AltoRouter $router)
    {
        parent::__construct();
        $this->router = $router;
    }

    public function index($params = []):void
    {
        SessionController::setSessionStart();

        if($this->authorized()){
            $profilePhoto = UsersModel::profilePhoto();
            
            $this->render("home", $params, $profilePhoto);
        }else{
            $loginController = new LoginController($this->router);
            $loginController->loginForNotLogged();
        }
    }

    /**
     * redirection vers le home de celui qui est déjà connecté
     * s'il tente d'avoir accès à une page dont il n'en a pas l'autorisation
     */
    public function indexForLogged()
    {
        SessionController::setSessionStart();
        $profilePhoto = UsersModel::profilePhoto();
        $this->render("home", $profilePhoto);
    }

    public function EditProfilePhoto()
    {
        $this->renderWithoutLayout('editProfilePhoto');
    }

    /**
     * @return array the calendar of the day fetchable by object
     */
    public function getTodayCalendar(): array
    {
        $calendarContentModel = $this->getCalendarContentModel();
        $datetime = new MyDateTime();
        $current_timestamp = $datetime->getDayCurrentTimestamp();
        
        $emploidutemps = $calendarContentModel->joinSelect(['t.*'], 
        ['t.date = ?', 'j.user_id = ?'],
        ['date' => (string)$current_timestamp, 'user_id' => User::getId()])
            ->orderBy('time')
            ->finalize();

        return $calendarContentModel->fetch($emploidutemps, Calendarcontent::class, true);
    }

    public function revision()
    { 
        $result = $this->getTodayCalendar();
        
        $this->renderWithoutLayout('homeContent.revision', $result);
    }

    public function getCalendarContentModel()
    {
        return $this->app->getModel("Emploidutempscontent");
    }

    public function calendar()
    {
        $calendarmodel = $this->app->getModel("Calendar");
        $idStatement = $calendarmodel->joinSelect(['t.id'], ['t.user_id = ?'], ['user_id' => User::getId()])->finalize();
        $emploiDuTempsId = $calendarmodel->fetch($idStatement, Calendar::class, true);
        
        if(!empty($emploiDuTempsId)){
            $calendarNumber = count($emploiDuTempsId);
            $calendarContentModel = $this->getCalendarContentModel();
            $finalResult = [];

            for($x = 0; $x < $calendarNumber; $x++){
                $contentStatement = $calendarContentModel->joinSelect(['t.*'], ['t.emploi_du_temps_id = ?'], ['emploi_du_temps_id' => $emploiDuTempsId[$x]->getId()])
                                                         ->orderBy('time')
                                                         ->finalize();
                
                $result = $calendarContentModel->fetch($contentStatement, Calendarcontent::class, true);
                
                if(!empty($result)){
                    $finalResult[] = $result;
                }
            }
            
            if(!empty($finalResult)){
                $this->renderWithoutLayout('homeContent.calendar', $finalResult);
            }else{
                echo "il semble que vous ayez un id d'emploi du temps mais il n'y a pas de contenu";
                
            }
        }else{
            echo 
            "<h1 class='not-even-calendar'>Vous n'avez pas encore d'emploi du temps !</h1><i class='fas fa-plus add-calendar'></i>
            <ul class='calendar-creation-instructions'>
                <li>Si vous revisez pour retenir vos cours, vous pouvez reviser 3 matières par jour.</li>
                <li>Vous pouvez monter jusqu'à 5 dont si les 2 matières supplémentaires sont pour des exercices.</li>
                <li>Libre à vous de gerer votre emploi du temps de la journée en ne dépassant simplement pas le quota de 3 matières pour les retentions.</li>
            </ul>
            ";
        }
    }

    public function tasks()
    {
        $this->renderWithoutLayout("homeContent.tasks");
    }

    public function help()
    {
        $this->renderWithoutLayout("homeContent.help");
    }

    /**
     * return the calendar content on array form
     */
    public function ArrayCalendarContent()
    {
        $calendarContentModel = $this->getCalendarContentModel();
        $datetime = new MyDateTime();
        $current_timestamp = $datetime->getDayCurrentTimestamp();

        $emploidutemps = $calendarContentModel->joinSelect(['t.*'], 
        ['t.date = ?', 'j.user_id = ?'],
        ['date' => (string)$current_timestamp, 'user_id' => User::getId()])
            ->orderBy('time')
            ->finalize();

        $result = $calendarContentModel->fetch($emploidutemps, null, true);
        if(!empty($result)){
            echo json_encode(['result' => $result]);
        }else{
            echo json_encode(["result" => null]);
        }
        
    }

    /**
     * execute a query to stop the revision of a subject after the user finished it
     */
    public function stopRevision()
    {
        
        if(!empty($_POST['status']) && !empty($_POST['subject-id']) && !empty($_POST['calendar-id'])){
            $calendarContentModel = $this->getCalendarContentModel();
            if($calendarContentModel->joinUpdate(
                ['done = ?' => (int)$_POST['status']], 
                ['t.id = ?' => (int)$_POST['subject-id'], 't.emploi_du_temps_id = ?' => $_POST['calendar-id']],
            ) !== null){
                echo json_encode(['success' => "La revision de cette matière est terminée"]);
            }else{
                echo json_encode(['fail' => "La revision de cette matière est terminée"]);
            }
        }    
    }


    public function saveRevisionForAnotherTime()
    {
        $calendarContentModel = $this->getCalendarContentModel();

        $myDatetime = new MyDateTime();
        $date = $myDatetime->getTimeStamp($_POST['date']);
        $time = $myDatetime->getTimeStamp($_POST['date'], $_POST['time']);
        //get the current hour of the revision
        //$subjectTime = $calendarContentModel->getSubjectTime((int)$_POST['subject-id'], $_POST['calendar-id']);
        //$subjectOfCalendarNumber = $calendarContentModel->countSubjects((int)$_POST['calendar-id'], (int)$_POST['subject-id']);
        //$subjectsId = $calendarContentModel->getSubjectsId((int)$_POST['calendar-id'], (int)$_POST['subject-id']);
        
        //le nombre de temps décalé en timestamp
        $ecartDeTemps = $time - (int)$_POST['current-time'];
        
        $timesAndIds = $calendarContentModel->getCalendarContent(
            ["t.time", "t.id"], 
            ["t.time >=" => (int)$_POST['current-time'], "t.emploi_du_temps_id" => (int)$_POST['calendar-id']]
        
        );
        
        $SuccessOrFail = [];
        for($i = 0; $i < count($timesAndIds); $i++){
            //PROBLEME : TOUT EST MISE A JOUR ALORS QU'IL NE FAUT LE FAIRE QU'AVEC CEUX A PARTIR DU CLIQUE
            if($calendarContentModel->joinUpdate(
                [
                    'date= ?' => $date,
                    'time = ?' => (int)$timesAndIds[$i]->getTime() + $ecartDeTemps
                ], 
                ['t.id = ?' => (int)$timesAndIds[$i]->getId(), 't.emploi_du_temps_id = ?' => $_POST['calendar-id']],
            ) !== null){
                if(!array_key_exists("success", $SuccessOrFail)){
                    $SuccessOrFail['success'] =  "revision sauvegardée avec succès !";
                }
                
            }else{
                if(!array_key_exists("fail", $SuccessOrFail)){
                    $SuccessOrFail['fail']  = "sauvegarde de la revision échouée !";
                }
            }
        }
        
        echo json_encode($SuccessOrFail);
    }
}