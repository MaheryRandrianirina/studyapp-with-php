<?php
namespace Core\Helpers;

use DateTime;
use DateTimeZone;

/**
 * Execute des opérations liées au DateTime
 * Il y aura peut-être des changements à l'avenir en vue de l'évolution du code
 */
class MyDateTime {
    private $datetime;

    public function __construct()
    {
        if($this->datetime === null){
            $this->datetime = new DateTime();
            $this->datetime->setTimezone(new DateTimeZone("Africa/Kampala"));
        }
    }

    /**
     * retourne le timestamp voulu
     * @param string $time timestamp avec l'heure
     * @param string $date timestamp de la date seulement
     * @return string timestamp
     */
    public function getTimeStamp(string $date, ?string $time = null)
    {
        $arrayFromDate = explode("-", $date);
        $this->datetime->setDate((int)$arrayFromDate[0], (int)$arrayFromDate[1], (int)$arrayFromDate[2]);
        $this->datetime->setTime(00, 00);

        if($time !== null){
            $arrayFromTime = explode(":", $time);
            $this->datetime->setTime((int)$arrayFromTime[0], (int)$arrayFromTime[1]);
        }
        
        $this->datetime->setTimezone(new DateTimeZone("Africa/Kampala"));
        return $this->datetime->getTimestamp();
    }

    public function getDatetimeWithParam(string $timestamp): DateTime
    {
        
        $datetime = new DateTime("@" .$timestamp);
        $datetime->setTimezone(new DateTimeZone("Africa/Kampala"));
        return $datetime;
    }

    public function getDate(string $timestamp): string
    {
        $datetime = $this->getDatetimeWithParam($timestamp);
        return $datetime->format("d-m-Y");
    }

    public function getTime(string $timestamp): string
    {
        $datetime = $this->getDatetimeWithParam($timestamp);
        return $datetime->format("H:i");
    }

    public function getDay(string $timestamp): string 
    {
        $days = [
            "Mon" => "Lundi",
            "Tue" => "Mardi",
            "Wed" => "Mercredi",
            "Thu" => "Jeudi",
            "Fri" => "Vendredi",
            "Sat" => "Samedi",
            "Sun" => "Dimanche"
        ];

        $datetime = $this->getDatetimeWithParam($timestamp);
        $day = $datetime->format("D");
        return $days[$day];
    }

    /**
     * retourne le timestamp de la journée à 00:00
     * @return int timestamp
     */
    public function getDayCurrentTimestamp(): int
    {
        $datetime = $this->getDatetimeWithParam(time());
        $datetime->setTime(00,00);
        return $datetime->getTimeStamp();
        
    }

    public function getTimeLeft(int $timestamp): string
    {
        $timestampLeft = time() - $timestamp;
        $timeLeft = $this->getTime($timestampLeft);
        $arrayFromTimeLeft = explode(":", $timeLeft);
        if($arrayFromTimeLeft[0] === "00"){
            return $arrayFromTimeLeft[1] . " min";
        }else{
            return $arrayFromTimeLeft[0] . " h " . $arrayFromTimeLeft[1] . " min";
        }
    }
}