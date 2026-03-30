<?php

namespace App\php\Controllers;

abstract class Controller
{
    protected $template;
    protected $service;

    protected $id_user;

    protected $role;

    protected $loggedin;

    abstract protected function getPageData();
}