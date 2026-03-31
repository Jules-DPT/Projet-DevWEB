<?php

namespace App\php\Controllers;

use App\php\Controllers\Controller;

class Errorcontroller extends Controller
{
    private $error;
    public function __construct($template_,$error_)
    {
        $this->template=$template_;
        $this->error=$error_;
    }
    public function getPageData()
    {
        header('Content-Type: text/html; charset=UTF-8');
        echo $this->template->render('Error.html.twig',["error"=>$this->error]);
    }
}