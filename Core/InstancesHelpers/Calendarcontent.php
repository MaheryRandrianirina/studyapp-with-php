<?php
namespace Core\InstancesHelpers;

use Core\Helpers\MyDateTime;
use Core\Interfaces\GlobalInterface;

class Calendarcontent implements GlobalInterface {
    private $id;
    private $subject;
    private $date;
    private $time;
    private $done;
    private $chapter;
    private $emploi_du_temps_id;

    public function getId(): string
    {
        return $this->id;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getTime(): string
    {
        return $this->time;
    }

    public function getDone()
    {
        return $this->done;
    }
    public function getChapter(): string
    {
        return $this->chapter;
    }

    public function getCalendarId(): string
    {
        return $this->emploi_du_temps_id;
    }

    public function all(): array
    {
        $datetime = new MyDateTime();
        return [
            "subject" => $this->getSubject(),
            "time" => $datetime->getTime($this->getTime()),
            "chapter" => $this->getChapter(),
            "status" => $this->getDone()
        ];
    }
}