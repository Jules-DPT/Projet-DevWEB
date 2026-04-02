<?php

namespace App\php\Controllers;

use App\php\Controllers\Controller;
use App\php\Services\Fileservice;
use App\php\Services\Postulationservice;

class Postulationcontroller extends Controller
{
    private $dir_path;
    private $id_cible;

    private $result;
    public function __construct($id_user_, $role_, $loggedin_,$file_,$id_post_,$LM_,$template_)
    {
        $this->template=$template_;
        $this->role = $role_;
        $this->loggedin = $loggedin_;
        $this->dir_path = '/Files/Utilisateurs/CV/';
        $this->service=new Postulationservice($id_post_,$id_user_,$file_,$this->dir_path,$LM_);
        $this->id_user = $this->service->getIdUtilisateur();
        $this->id_cible = $this->service->getIdpost();

    }
    public function getPageData()
    {
        $check=$this->checkPostulation();
        header('Content-Type: text/html; charset=UTF-8');
        switch ($this->role) {
            case "ETUDIANT" and $check==false:
                echo $this->template->render('Postulation.html.twig',['id_cible'=>$this->id_cible,'result'=>"null"]);
                break;

            default:
                header("Location: /recherche/fiche?type=3&page=1&id_cible=".$this->id_cible);
                break;
        }

    }
    public function getPostulationData(){
        $this->result=$this->service->getPageData();
        header('Content-Type: text/html; charset=UTF-8');
        echo $this->template->render('Postulation.html.twig',['id_cible'=>$this->id_cible,'result'=>$this->result]);
    }

    public function checkPostulation()
    {
        return $this->service->checkPostulation();
    }
}