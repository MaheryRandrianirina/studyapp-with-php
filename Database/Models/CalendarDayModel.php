<?php
namespace Database\Models;

class CalendarDayModel extends Model {
    protected $table = "emploi_du_temps_day";
    /**
     * @var $tableToJoin nom de la table à joindre
     */
    protected $tableToJoin = "emploi_du_temps_content";
    /**
     * @var $fieldForJoin nom du champ qui joint
     */
    protected $fieldForJoin = 'user_id';
    /**
     * @var $tableField  nom du champ de $tableToJoin joint
     */
    protected $tableField = "emploi_du_temps_id";
    public function insert($fields = [], $data = []): bool
    {
        $this->posts = $data;
        return parent::insert($fields);
    }
}