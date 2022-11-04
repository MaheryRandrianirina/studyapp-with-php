<?php
namespace App\Controllers;

use Core\Helpers\User;

class CalendarController extends Controller {

    public function dropCalendar(): void
    {
        $calendarModel = $this->app->getModel("Calendar");

        if($calendarModel->delete([], ['user_id' => User::getId()])){
            echo json_encode(['success' => true]);
            exit();
        }else{
            echo json_encode(['fail' => true]);
            exit();
        }
    }
}