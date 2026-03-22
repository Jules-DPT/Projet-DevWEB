<?php

namespace App\php\Controllers;

abstract class Controller
{
    protected $template;
    protected $service;

    abstract protected function getPageData();
}