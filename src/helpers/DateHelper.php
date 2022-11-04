<?php
namespace src\helpers;

use DateTime;

class DateHelper {
    private static $_instance;
    private $datetime;

    public static function getInstance(): self
    {
        if(self::$_instance === null){
            self::$_instance = new DateHelper();
        }
        return self::$_instance;
    }
    public function __construct()
    {
        if($this->datetime === null){
            $this->datetime = new DateTime();
        }
        
    }
    

    public function getCurrentDate(): string
    {
        return $this->datetime->format("d/m/Y");
    }
}