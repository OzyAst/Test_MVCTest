<?php

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