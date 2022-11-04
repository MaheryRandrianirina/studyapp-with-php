<?php
namespace Database;

use PDO;

use function PHPSTORM_META\map;

class Database {
    private static $_instance;
    private $pdo;
    public $posts = [];
    const HOST = "localhost";
    const USERNAME = "root";
    const PASSWORD = "root";
    const DBNAME = "studyapp";

    public static function getInstance(): self
    {
        if(self::$_instance === null){
            self::$_instance = new Database();
        }
        return self::$_instance;
    }

    public function __construct()
    {
        if($this->pdo === null){
            $this->pdo = new PDO("mysql:host=".self::HOST.";dbname=".self::DBNAME."", self::USERNAME, self::PASSWORD);
        }
    }

    public function getPDO(): PDO
    {
        return $this->pdo;
    }
    
    /**
     * execute la requete
     * 
     * @param  mixed $statement
     * @param  mixed $data
     * @param  mixed $constraints
     * @return bool
     */
    public function execute($statement, $data = [], $constraints = []): bool
    {
        $executeArray = [];
        
        if($constraints === null){
            return $statement->execute();
            
        }else{
            foreach($data as $key => $value){
                
                if(!in_array($key, $constraints)){
                    
                    $executeArray[] = $value;
                }
                
            }

            return $statement->execute($executeArray);
        }

        
        
    }

    public function prepare(string $query, $data = [], $constraints = [])
    {
        $statement = $this->pdo->prepare($query);
        
        if($this->execute($statement, $data, $constraints)){
            return $statement;
        }else{
            return null;
        }
    }

    public function insert(string $table, $fields = [], $posts = [], $constraints = []): bool
    {
        $this->posts = $posts;
        $stringFromFields = implode(", ", $fields);
        $prepare = "INSERT INTO " . $table . "(" . $stringFromFields . ") VALUES(";
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
    
    /**
     * select
     * atao manao retour type anle données (interface ngamba nom ampiasaina)
     * @param  mixed $table
     * @return void
     */
    public function select(string $table, $what = [], $where = [])
    {
        $what = implode(", ", $what);
        $where = implode(", ", $where);
        
        $query = "SELECT " . $what . " FROM " . $table . " WHERE " . $where;
        
        if($this->prepare($query) !== null){
            echo "ok";
        }else{
            //echo "vous n'existez"
        }
    }
}