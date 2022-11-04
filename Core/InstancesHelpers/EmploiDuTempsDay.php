<?php
namespace Core\InstancesHelpers;

use Core\Interfaces\GlobalInterface;

class EmploiDuTempsDay implements GlobalInterface {
    private $id;
    private $calendar_timestamp;
    private $emploi_du_temps_id;
    private $user_id;

    public function getId(): int
    {
        return $this->id;
    }

    public function getCalendarTimestamp(): string
    {
        return $this->calendar_timestamp;
    }

    public function getEmpoiDuTempsId(): int
    {
        return $this->emploi_du_temps_id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }
}