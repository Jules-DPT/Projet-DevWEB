<?php

namespace App\php\Controllers;


use App\php\Services\Postulationservice;
use App\php\Services\Recherchesservice;

ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');





class Recherchecontroller extends Controller
{
    private $Page;

    private $recherche;

    private $type;

    private $postulationservice;

    public function __construct($int,$page_,$recherche_,$template_,$id_user_)
    {
        $this->id_user=$id_user_;
        $this->template=$template_;
        $this->Page = $page_;
        $this->recherche = $recherche_;
        $this->type = $int;
        $this->service = new Recherchesservice($this->Page,$int,$this->recherche);
        $this->postulationservice = new Postulationservice($this->id_user);
    }

    public function getPageData()
    {
        $contenant = $this->service->getPageData();
        $nb=count($contenant) ;
        $totalpages= $this->service->getTotalPages();

        $page=$this->service->getPage();
        $path=$this->service->getPath("?recherche=".$this->recherche."&type=".$this->type);
        header('Content-Type: text/html; charset=UTF-8');
        if ($nb==0 )
        {
            echo $this->template->render('Recherche.html.twig',["res"=>null,"totalPages"=>$totalpages,"path"=>$path,"page"=>$page,"type"=>$this->type]);
        }
        else
        {
            if($this->type==3)
            {
                $check=$this->postulationservice->getCheckPosts($contenant);
                echo $this->template->render('Recherche.html.twig',["contenant"=>$contenant,"res"=>1,"totalPages"=>$totalpages,"path"=>$path,"page"=>$page,"type"=>$this->type,"check"=>$check]);
            }
            else
            {
                echo $this->template->render('Recherche.html.twig',["contenant"=>$contenant,"res"=>1,"totalPages"=>$totalpages,"path"=>$path,"page"=>$page,"type"=>$this->type]);
            }

        }


    }
}


