<?php

namespace App\php\Controllers;

use App\php\Controllers\Controller;

class Robotcontroller extends Controller
{

    public function __construct($template_)
    {
        $this->template=$template_;

    }
    public function getPageData()
    {
        header('Content-Type: text; charset=UTF-8');
        echo $this->template->render('robots.txt');
    }
}