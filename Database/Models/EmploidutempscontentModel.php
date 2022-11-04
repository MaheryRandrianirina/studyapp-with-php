<?php
namespace Database\Models;

use Core\Helpers\MyDateTime;
use Core\Helpers\User;
use Core\InstancesHelpers\Calendarcontent;

class EmploidutempscontentModel extends Model {
    /**
     * @var $table nom de la table principale
     */
    protected $table = "emploi_du_temps_content";
    /**
     * @var $tableToJoin nom de la table à joindre
     */
    protected $tableToJoin = "emploi_du_temps";

    protected $secondTableToJoin = "user";
    /**
     * @var $fieldForJoin nom du champ qui joint
     */
    protected $fieldForJoin = 'emploi_du_temps_id';
    
    protected $secondFieldForJoin = "user_id";
    /**
     * @var $tableField  nom du champ de $tableToJoin joint
     */
    protected $tableField = "id";
    /**
     * modifie la fonction parent en ajoutant $data
     * @param mixed $data : un tableau associatif
     */

    public function insert($fields = [], $data = []): bool
    {
        $this->posts = $data;
        return parent::insert($fields);
    }

    //TY NO TENA IZY FA VAO AMBOARINA
    public function getTodayCalendar()
    {
        $datetime = new MyDateTime();
        $current_timestamp = $datetime->getDayCurrentTimestamp();
        
        $emploidutemps = $this->joinSelect(['t.*'], ['t.date = ?', 'j.user_id = ?'],['date' => (string)$current_timestamp, 'user_id' => User::getId()])
            ->orderBy('time')
            ->finalize();

        return $this->fetch($emploidutemps, Calendarcontent::class, true);
    }

    /**
     * gets the time predifined to revise the subject of specified calendar
     */
    public function getSubjectTime(int $subjectId, int $calendarId)
    {
        $select = $this->joinSelect(
            ["t.time"], 
            ["t.id = ?", "t.emploi_du_temps_id = ?"],
            ["id" => $subjectId, "emploi_du_temps_id" => $calendarId]
        )->finalize();

        if($select !== null){
            return $this->fetch($select, Calendarcontent::class);
        }
    }
    
    /**
     * countSubjects
     * counts the subjects number in a calendar
     * @param  mixed $calendarId where to count the subjects
     * @param  mixed $subjectId if !null, this function counts the subjects after this subject id
     * @return void
     */
    public function countSubjects(int $calendarId, ?int $subjectId = null)
    {
        $select = null;
        if($subjectId === null){
            $select = $this->joinSelect(["COUNT(t.id)"], ["t.emploi_du_temps_id = ?"], ["emploi_du_temps_id" => $calendarId])
            ->finalize();
        }else{
            $select = $this->joinSelect(
                ["COUNT(t.id)"], 
                ["t.emploi_du_temps_id = ?", "t.id >= ?"], 
                ["emploi_du_temps_id" => $calendarId, "id" => $subjectId]
            )->finalize();
        }
        

        if($select !== null){
            return $this->fetch($select, null);
        }
    }

    public function getSubjectsId(int $calendarId, int $subjectId): ?array
    {
        $select = $this->joinSelect(
            ["t.id"], 
            ["t.emploi_du_temps_id = ?", "t.id >= ?"], 
            ["emploi_du_temps_id" => $calendarId, "id" => $subjectId]
        )->finalize();
        
        if($select !== null){
            $result = $this->fetch($select, Calendarcontent::class, true);
            if($result !== null){
                return $result;
            }else{
                return null;
            }
        }
        return null;
    }

    public function getCalendarContent(array $what, array $wheres = []): ?array
    {
        $where = [];
        $whereValues = [];

        foreach($wheres as $k => $v){
            //$substr = substr($k, -2);
            
            if(strstr($k, ">") || strstr($k, "<")){
                $where[] = $k . " ?";
                
            }else{
                $where[] = $k . " = ?";
            }
            
            
            $whereValues[$k] = $v;
        }
        
        $selectStatement = $this->joinSelect($what, $where, $whereValues)
                             ->finalize();

        $results = $this->fetch($selectStatement, Calendarcontent::class, true);

        if(!empty($results)){
            return $results;
        }
        return null;
    }
}