<?php

namespace App\php\Controllers;

use App\php\Controllers\Controller;
use App\php\Services\Paginationservice;

class Mentionscontroller extends Controller
{
    public function __construct($role_,$template_)
    {
        $this->template=$template_;
        $this->service=new Paginationservice();
        $this->role=$role_;
    }
    public function getPageData()
    {
        $path=$this->service->getPath("");
        header('Content-Type: text/html; charset=UTF-8');

        echo $this->template->render('Mentions-legales.html.twig',["role"=>$this->role,"path"=>$path]);
    }
}