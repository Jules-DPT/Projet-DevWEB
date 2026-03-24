<?php

namespace App\php\Controllers;

abstract class Controller
{
    protected $template;
    protected $service;

    protected $id_user;

    abstract protected function getPageData();
}