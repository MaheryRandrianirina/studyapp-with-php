<?php
namespace Database\Models;

use Core\Interfaces\GlobalInterface;
use Database\Database;
use PDO;
use PDOStatement;

class Model {
    protected $database;
    protected $posts = [];
    /**
     * @var array list of agregats functions
     */
    const AGREGATS = ["COUNT", "SUM"];
    /**
     * @var $query la requête
     */
    protected $query = "";
    /**
     * @var $whereValues les valeurs du where à passer en param de execute()
     */
    protected $whereValues;

    public function __construct()
    {
        if($this->database === null){
            $this->database = Database::getInstance();
        }
    }

    /**
     * execute la requete
     * 
     * @param  mixed $statement
     * @param  mixed $data
     * @param  mixed $constraints indique ceux dont on ne doit pas rentrer dans $executeArray
     * @return bool
     */
    public function execute($statement, $data = [], $constraints = []): bool
    {
        $executeArray = [];

        if($constraints === null || empty($constraints === null)){
            if($data === null || empty($data)){
                return $statement->execute();
            }else{
                
                foreach($data as $d){
                    if(!is_array($d)){
                        $executeArray[] = $d;
                    }else{
                        
                        foreach($d as $val){
                            $executeArray[] = $val;
                        }
                    }
                    
                }
                
                return $statement->execute($executeArray);
            }
            
            
        }else{
            foreach($data as $key => $value){
                
                if(!in_array($key, $constraints)){
                    
                    $executeArray[] = $value;
                }
                
            }
            return $statement->execute($executeArray);
        }

        
        
    }

    public function prepare($query, $data = [], $constraints = [])
    {
        $statement = $this->database->getPDO()->prepare($query);
        
        if($this->execute($statement, $data, $constraints)){
            return $statement;
        }else{
            return null;
        }
    }
    
    /**
     * insert les elements dans la base de données
     * @param  mixed $fields
     * @param  mixed $constraints : les éléments à exclure de l'insertion(souvent "name" via formulaire)
     * @return bool
     */
    public function insert($fields = [], $constraints = []): bool
    {
        $stringFromFields = implode(", ", $fields);
        $prepare = "INSERT INTO " . $this->table . "(" . $stringFromFields . ") VALUES(";
        $array = [];

        foreach ($fields as $field) {
            $array[]= "?";
        }

        $prepare .= implode(",", $array) .")";
        if($this->prepare($prepare, $this->posts, $constraints) !== null){
            return true;
        }
        return false;
    }

    public function update(array $fields, array $wheres): bool
    {
        $stringFromFields = implode(", ", $fields);
        $whr = "";
        foreach($wheres['where'] as $key => $where){
            $whr .= $key . $where . " AND ";
        }
        
        $arrayFromWhr = explode(" AND ", $whr);
        array_pop($arrayFromWhr);
        $whr = implode(" AND ", $arrayFromWhr);
        
        $prepare = "UPDATE " . $this->table . " SET " . $stringFromFields . " WHERE " . $whr;
        
        if($this->prepare($prepare, $this->posts) !== null){
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * select
     * un simple select (sans jointure ou autre)
     * @param  mixed $table
     * @return void
     */
    public function select(array $what = [], array $where = [], array $whereValues = []):?PDOStatement
    {
        
        $what = implode(", ", $what);
        $where = implode(" AND ", $where);
        $query = null;

        if(!empty($where)){
            $query = "SELECT " . $what . " FROM " . $this->table . " WHERE " . $where;
        }else{
            $query = "SELECT " . $what . " FROM " . $this->table;
            
        }
        
        if($this->prepare($query, $whereValues) !== null){
            return $this->prepare($query, $whereValues);
        }else{
            return null;
        }
    }

    /**
     * joinSelect
     * fait un select avec jointure
     * Il faut préciser dans $what à partir de quelle table on veu faire le select
     * @param array $what ex: ['t.id', 't.subject', 'j.id']
     * @param array $where ex: ['t.id = ?']
     * @param array $whereValues ex: ['t.id' => User::getId()]
     */
    public function joinSelect(array $what = [], array $where = [], array $whereValues = []): self
    {
        
        $what = implode(", ", $what);
        /**
         * @var array $resultsForAgregats not empty if there are agregats functions
         */
        $resultsForAgregats = [];

        foreach(self::AGREGATS as $agregat){
            if(strstr($what, $agregat) !== false){
                $resultsForAgregats[] = strstr($what, $agregat);
            }
            
        }

        $where = implode(" AND ", $where);
        $this->whereValues = $whereValues;
        
        if(empty($resultsForAgregats)){
            if(!empty($where)){
                $this->query = "
                SELECT " . $what . " FROM " 
                . $this->table .
                " t JOIN " .$this->tableToJoin .
                " j ON t." .$this->fieldForJoin. " = j."  .$this->tableField .
                " WHERE " . $where;
            }else{
                $this->query = "
                SELECT " . $what . " FROM " 
                . $this->table .
                " t JOIN " .$this->tableToJoin.
                " j ON t." .$this->fieldForJoin. " = j."  .$this->tableField;
                
            }
        }else{
            if(!empty($where)){
                $this->query = "
                SELECT " . $what . " FROM " 
                . $this->table .
                " t JOIN " .$this->tableToJoin .
                " j ON t." .$this->fieldForJoin. " = j."  .$this->tableField .
                " WHERE " . $where;
            }else{
                $this->query = "
                SELECT " . $what . " FROM " 
                . $this->table .
                " t JOIN " .$this->tableToJoin.
                " j ON t." .$this->fieldForJoin. " = j."  .$this->tableField;
                
            }
        }
        return $this;
        
    }

    /**
     * finalise la requête
     */
    public function finalize()
    {
        if($this->prepare($this->query, $this->whereValues) !== null){
            return $this->prepare($this->query, $this->whereValues);
        }else{
            return null;
        }
    }
    
    /**
     * fetch
     *
     * @param  mixed $statement
     * @param  mixed $classForFetch
     * @param  mixed $all précise si on doit faire un fetchAll ou un simple fetch
     * @return GlobalInterface
     */
    public function fetch($statement, $classForFetch = null, bool $all = false)
    {
        if(!$all){
            return $this->fetchManager($statement, $classForFetch);
        }else{
            return $this->fetchManager($statement, $classForFetch, true);
        }
    }
    
    /**
     * fetchManager
     * gère s'il faut fetchAll ou faire un simple fetch sur le statement
     * @param  mixed $statement
     * @param  mixed $classForFetch
     * @param  mixed $all
     * @return void
     */
    public function fetchManager($statement, $classForFetch = null, bool $all = false)
    {
        if($classForFetch !== null){
            $statement->setFetchMode(PDO::FETCH_CLASS, $classForFetch);
        }else{
            $statement->setFetchMode(PDO::FETCH_ASSOC);
        }
        
        $result = null;

        if(!$all){
            $result = $statement->fetch();
        }else{
            $result = $statement->fetchAll();
        }

        if($result !== null){
            return $result;
        }

        return null;
    }
    
    /**
     * orderBy
     * trie les elements par ordre
     * @param  string $field
     * @return void
     */
    public function orderBy(string $field):self
    {
        $this->query = $this->query . " ORDER BY " . $field;
        return $this;
    }

    /**
     * commence la transaction
     */
    public function beginTransaction()
    {
        $this->database->getPDO()->beginTransaction();
    }

    /**
     * fait un rollback s'il y a eu des problèmes lors des executions des reqûetes
     */
    public function commit()
    {
        $this->database->getPDO()->commit();
    }

    public function joinUpdate(array $set, array $where): bool
    {
        $values = [];
        $name = [];
        $wheres = [];
        
        foreach($set as $n => $v){
            $values[$n] = $v;
            $name[] = $n;
        }
        
        foreach($where as $k => $v){
            $values[$k] = $v;
            $wheres[] = $k;
        }

        $implodedName = implode(", ", $name);
        $wheres = implode(" AND ", $wheres);
        $query = "
        UPDATE " .$this->table .  
        " t JOIN " .$this->tableToJoin . " j_one ON t." .$this->fieldForJoin. " = j_one." .$this->tableField.
        " SET t." . $implodedName .
        " WHERE " .$wheres;
        
        if($this->prepare($query, $values) !== null){
            return true;
        }else{
            return null;
        }
    }

    public function delete(array $what = [], array $wheres = []): bool
    {  
        $query = "";
        
        if(empty($what)){
            
            $where = [];
            $whereValues = [];

            foreach($wheres as $k => $v){
                $where[] = $k . " = ?";
                $whereValues[$k] = $v;
            }

            $where = implode(' AND ', $where);
            $query = "DELETE FROM " . $this->table . " WHERE " . $where; 
        }

        if(empty($where)){
            $what = implode(", ", $what);
            $query = "DELETE " . $what . " FROM " . $this->table;
        }

        if(empty($what) && empty($wheres)){
            $query = "DELETE FROM " . $this->table;
        }
        
        if($this->prepare($query, $whereValues) !== null){
            return true;
        }else{
            return false;
        }
    }
}