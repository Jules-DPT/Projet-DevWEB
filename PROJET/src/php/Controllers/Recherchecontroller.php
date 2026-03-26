<?php

namespace App\php\Controllers;


use App\php\Services\Postulationservice;
use App\php\Services\Recherchesservice;


class Recherchecontroller extends Controller
{
    private $Page;

    private $recherche;

    private $type;

    private $postulationservice;

    public function __construct($type,$page_,$recherche_,$template_,$id_user_,$role_)
    {
        $this->id_user=$id_user_;
        $this->role=$role_;
        $this->template=$template_;
        $this->Page = $page_;
        $this->recherche = $recherche_;
        $this->service = new Recherchesservice($this->Page,$type,$this->recherche,$this->role,$this->id_user);
        $this->postulationservice = new Postulationservice($this->id_user);
    }

    public function getPageData()
    {
        $contenant = $this->service->getPageData();
        $nb=count($contenant) ;
        $totalpages= $this->service->getTotalPages();

        $page=$this->service->getPage();
        $this->type=$this->service->getType();
        $this->recherche=$this->service->getRecherche();
        $path=$this->service->getPath("?recherche=".$this->recherche."&type=".$this->type);
        header('Content-Type: text/html; charset=UTF-8');
        if ($nb==0 )
        {
            echo $this->template->render('Recherche.html.twig',["res"=>null,"totalPages"=>$totalpages,"path"=>$path,"page"=>$page,"type"=>$this->type,"role"=>$this->role]);
        }
        else
        {
            if($this->type==3)
            {
                $check=$this->postulationservice->getCheckPosts($contenant);
                echo $this->template->render('Recherche.html.twig',["contenant"=>$contenant,"res"=>1,"totalPages"=>$totalpages,"path"=>$path,"page"=>$page,"type"=>$this->type,"check"=>$check,"role"=>$this->role]);
            }
            else
            {
                echo $this->template->render('Recherche.html.twig',["contenant"=>$contenant,"res"=>1,"totalPages"=>$totalpages,"path"=>$path,"page"=>$page,"type"=>$this->type,"role"=>$this->role]);
            }

        }


    }
}


