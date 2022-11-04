<?php
namespace Core\InstancesHelpers;

use Core\Interfaces\GlobalInterface;

class Help implements GlobalInterface {
    private $id;
    private $subject;
    private $date;
    private $chapter;
    private $user_id;

    public function getId()
    {
        return $this->id;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getChapter()
    {
        return $this->chapter;
    }

    public function getUserId()
    {
        return $this->user_id;
    }
}