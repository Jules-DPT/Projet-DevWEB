<?php

namespace App\php\Controllers;

use App\php\Controllers\Controller;

class Indexcontroller extends Controller
{

    public function __construct($template_)
    {
        $this->template=$template_;
    }
    public function getPageData()
    {
        header('Content-Type: text/html; charset=UTF-8');
        $path="/ ";
        echo $this->template->render('welcomepage.html.twig',["path"=>$path]);
    }
}