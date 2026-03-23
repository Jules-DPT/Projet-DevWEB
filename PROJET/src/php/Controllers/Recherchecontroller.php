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

    private $type;

    public function __construct($int,$page_,$recherche_,$template_)
    {

        $this->template=$template_;
        $this->Page = $page_;
        $this->recherche = $recherche_;
        $this->type = $int;
        $this->service = new Recherchesservice($this->Page,$int,$this->recherche);
    }

    public function getPageData()
    {
        $contenant = $this->service->getPageData();
        $totalpages= $this->service->getTotalPages();
        $page=$this->service->getPage();
        $path=$this->service->getPath("?recherche=".$this->recherche."&type=".$this->type);
        header('Content-Type: text/html; charset=UTF-8');
        if (count($contenant) ==0 )
        {
            echo $this->template->render('Recherche.html.twig',["contenant"=>$contenant,"res"=>null,"totalPages"=>$totalpages,"path"=>$path,"page"=>$page,"type"=>$this->type]);
        }
        else
        {
            echo $this->template->render('Recherche.html.twig',["contenant"=>$contenant,"res"=>1,"totalPages"=>$totalpages,"path"=>$path,"page"=>$page,"type"=>$this->type]);
        }


    }
}


