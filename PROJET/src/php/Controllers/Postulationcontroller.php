<?php

namespace App\php\Controllers;

use App\php\Controllers\Controller;
use App\php\Services\Fileservice;
use App\php\Services\Postulationservice;

class Postulationcontroller extends Controller
{
    public function __construct($id_user_, $role_, $loggedin_,$file_,$id_post_)
    {
        $this->id_user = $id_user_;
        $this->role = $role_;
        $this->loggedin = $loggedin_;
        $this->service=new Postulationservice($id_post_,$id_user_,$file_,"../../../../Files/utilisateur/CV/");


    }
    protected function getPageData()
    {

        switch ($this->role) {
            case "ETUDIANT":
                echo $this->template->render('Postulation.html.twig');
                break;
            default:
                echo $this->template->render('welcomepage.html.twig');
                break;
        }
    }
}