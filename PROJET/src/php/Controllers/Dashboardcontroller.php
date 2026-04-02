<?php

namespace App\php\Controllers;

use App\php\Controllers\Controller;
use App\php\Services\Statservice;

class Dashboardcontroller extends Controller
{

    public function __construct($id_user_,$role_,$loggedin_,$template_)
    {
        $this->id_user=$id_user_;
        $this->role=$role_;
        $this->loggedin=$loggedin_;
        $this->template=$template_;
        $this->service=new Statservice(5,$this->role,$this->id_user);
    }
    public function getPageData()
    {
        if($this->loggedin) {
            header('Content-Type: text/html; charset=UTF-8');
            switch ($this->role)
            {
                case 'ADMIN':
                    $NbUsers = $this->service->getNbUsers();
                    $NbPosts = $this->service->getNbPosts();
                    $NbEntreprises = $this->service->getNbEntreprises();
                    echo $this->template->render('Dashboard.html.twig', ['role' => $this->role, "NbUsers" => $NbUsers,"NbPosts" => $NbPosts,"NbEntreprises" => $NbEntreprises]);
                    break;
                case 'ETUDIANT':
                    $NbWishes = $this->service->getNbWishes();
                    echo $this->template->render('Dashboard.html.twig', ['role' => $this->role, "NbWishes" => $NbWishes]);
                    break;
                case 'PILOTE':
                    $StudentByPost = $this->service->getStudentByPostulation();
                    echo $this->template->render('Dashboard.html.twig', ['role' => $this->role, "StudentByPost" => $StudentByPost]);
                    break;
                default:
                    header('location: /');
                    break;
            }
        }
        else
        {
            header('location: /');
        }
    }
}