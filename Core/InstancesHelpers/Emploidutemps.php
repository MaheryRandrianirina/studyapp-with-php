<?php
namespace Core\InstancesHelpers;

use Core\Interfaces\GlobalInterface;

class Emploidutemps implements GlobalInterface {
    private $id;
    private $user_id;

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }
}