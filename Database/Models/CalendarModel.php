<?php
namespace Database\Models;

class CalendarModel extends Model {
    /**
     * @var $table nom de la table principale
     */
    protected $table = "emploi_du_temps";
    /**
     * @var $tableToJoin nom de la table à joindre
     */
    protected $tableToJoin = "user";
    /**
     * @var $fieldForJoin nom du champ qui joint
     */
    protected $fieldForJoin = 'user_id';
    /**
     * @var $tableField  nom du champ de $tableToJoin joint
     */
    protected $tableField = "id";

    public function insert($fields = [], $data = []): bool
    {
        $this->posts = $data;
        return parent::insert($fields);
    }
}