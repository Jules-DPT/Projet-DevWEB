<?php

namespace App\php\Controllers;

use App\php\Controllers\Controller;
use App\php\Services\Compteservice;
use App\php\Services\Logioservice;
use App\php\Services\Statservice;

class Dashboardcontroller extends Controller
{
    private $type;
    public function __construct($id_user_,$role_,$loggedin_,$type_,$template_)
    {
        $this->id_user=$id_user_;
        $this->role=$role_;
        $this->loggedin=$loggedin_;
        $this->template=$template_;
        if($type_===null){
            $this->type=3;
        }
        elseif($type_>3 or $type_<1){
            $this->type=3;
        }
        else{
            $this->type=(int)$type_;
        }
        switch($this->type){
            case 1:
                $this->service=new Statservice(5,$this->role,$this->id_user);
                break;
            case 2:
                $this->service=new Compteservice($this->role,$this->id_user);
                break;
            case 3:
                $this->service=new Logioservice($this->id_user,$this->role,$this->loggedin);
                break;
        }

    }
    public function getPageData()
    {
        if($this->loggedin) {
            header('Content-Type: text/html; charset=UTF-8');
            if ($this->type==1) {
                switch ($this->role)
                {
                    case 'ADMIN':
                        $NbUsers = $this->service->getNbUsers();
                        $NbPosts = $this->service->getNbPosts();
                        $NbEntreprises = $this->service->getNbEntreprises();
                        echo $this->template->render('Dashboard.html.twig', ['type'=>$this->type,'role' => $this->role, "NbUsers" => $NbUsers,"NbPosts" => $NbPosts,"NbEntreprises" => $NbEntreprises]);
                        break;
                    case 'ETUDIANT':
                        $NbWishes = $this->service->getNbWishes();
                        echo $this->template->render('Dashboard.html.twig', ['type'=>$this->type,'role' => $this->role, "NbWishes" => $NbWishes]);
                        break;
                    case 'PILOTE':
                        $StudentByPost = $this->service->getStudentByPostulation();
                        echo $this->template->render('Dashboard.html.twig', ['type'=>$this->type,'role' => $this->role, "StudentByPost" => $StudentByPost]);
                        break;
                    default:
                        header('location: /');
                        break;
                }
            }
            elseif ($this->type==2) {
                $compte=$this->service->getCompte();
                echo $this->template->render('Dashboard.html.twig', ['type'=>$this->type,'role' => $this->role, "compte" => $compte]);
            }
            elseif ($this->type==3) {
                echo "deso";
            }

        }
        else
        {
            header('location: /');
        }
    }
}