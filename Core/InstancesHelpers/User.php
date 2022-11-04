<?php
namespace Core\InstancesHelpers;

use Core\Interfaces\GlobalInterface;

class User implements GlobalInterface {
    private $id;
    private $username;
    private $mail;
    private $birth;
    private $country;
    private $city;
    private $sexe;
    private $password;

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getMail()
    {
        return $this->mail;
    }

    public function getBirth()
    {
        return $this->birth;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function getSexe()
    {
        return $this->sexe;
    }

    public function getPassword()
    {
        return $this->password;
    }
}