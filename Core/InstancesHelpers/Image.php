<?php

namespace Core\InstancesHelpers;

use Core\Interfaces\GlobalInterface;

class Image implements GlobalInterface {
    private $id;
    private $path;
    private $extension;
    private $size;
    private $user_id;

    public function getId()
    {
        return $this->id;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getExtension()
    {
        return $this->extension;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function getuserId()
    {
        return $this->userId;
    }
}