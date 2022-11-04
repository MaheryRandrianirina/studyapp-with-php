<?php
namespace App\Controllers;
use App\Controllers\SessionController;
use AltoRouter;


class AppController extends Controller{
    public function __construct(AltoRouter $router)
    {
        parent::__construct();
        $this->router = $router;
    }

}