<?php

namespace App\php\Controllers;


use App\php\Services\Recherchesservice;

ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');





class Recherchecontroller extends Controller
{
    private $Page;

    private $recherche;


    public function __construct($int,$page_,$recherche_,$template_)
    {

        $this->template=$template_;
        $this->Page = $page_;
        $this->recherche = $recherche_;
        $this->service = new Recherchesservice($this->Page,$int,$this->recherche);
    }

    public function getPrimaryData()
    {
        $contenant = $this->service->getPrimaryData();
        header('Content-Type: text/html; charset=UTF-8');
        echo $this->template->render('Recherche.html.twig',["contenant"=>$contenant]);

    }
}


