<?php

namespace Ozycast\core;

use Ozycast\app\models\User;
use Ozycast\core\View;

class Controller
{

    public $model;
    public $view;
    public $user;

    function __construct()
    {
        $this->user = new User();
        $this->view = new View();
    }

}