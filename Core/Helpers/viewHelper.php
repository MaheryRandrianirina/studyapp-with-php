<?php
namespace Core\Helpers;

class viewHelper {
    public static function getImage(string $path)
    {
        readfile(dirname(__DIR__,2) . DIRECTORY_SEPARATOR . "data". DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . $path);
    }
}