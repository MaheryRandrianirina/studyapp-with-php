<?php
namespace Database\Models;

use Database\Database;

class SubjectModel extends Model{
    public function __construct()
    {
        parent::__construct(Database::getInstance());
    }
    public function getTodayRevision(int $user_id)
    {
        $this->database->prepare("SELECT * FROM"); //mbola tohizana ny requete
    }
}