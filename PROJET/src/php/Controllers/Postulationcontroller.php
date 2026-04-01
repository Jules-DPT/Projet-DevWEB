<?php

namespace App\php\Controllers;

use App\php\Controllers\Controller;
use App\php\Services\Fileservice;
use App\php\Services\Postulationservice;

class Postulationcontroller extends Controller
{
    private $dir_path;
    public function __construct($id_user_, $role_, $loggedin_,$file_,$id_post_,$LM_)
    {
        $this->id_user = $id_user_;
        $this->role = $role_;
        $this->loggedin = $loggedin_;
        $this->dir_path='../../../../Files/utilisateur/CV/';
        $this->service=new Postulationservice($id_post_,$this->id_user,$file_,$this->dir_path,$LM_);

    }
    public function getPageData()
    {
        $result=$this->service->getPageData();
        $check=$this->service->checkPostulation();
        switch ($this->role) {
            case "ETUDIANT" and $check==false:
                echo $this->template->render('Postulation.html.twig',["result"=>$result]);
                break;
            default:
                header("Location: /");
                break;
        }
    }
}