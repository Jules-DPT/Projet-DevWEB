<?php

namespace App\php\Controllers;

use App\php\Controllers\Controller;
use App\php\Repositories\Postsrepository;
use App\php\Services\Logioservice;

class Logiocontroller extends Controller
{
    private $email;
    private $password;


    private function __construct1($id_user_,$role_,$loggedin_,$template_)
    {
        $this->id_user = $id_user_;
        $this->role = $role_;
        $this->loggedin = $loggedin_;
        $this->template = $template_;
    }

    private function __construct2($id_user_,$role_,$loggedin_,$email_,$password_,$template_)
    {
        $this->id_user = $id_user_;
        $this->role = $role_;
        $this->loggedin = $loggedin_;
        $this->email = $email_;
        $this->password = $password_;
        $this->template = $template_;
    }

    public function __construct()
    {

        $num=func_num_args();
        switch ($num) {
            case 4:
                $this->__construct1(func_get_arg(0), func_get_arg(1),func_get_arg(2),func_get_arg(3)); break;
            case 6:
                $this->__construct2(func_get_arg(0), func_get_arg(1),func_get_arg(2),
                    func_get_arg(3),func_get_arg(4),func_get_arg(5)); break;
        }
        $this->service = new Logioservice($this->id_user, $this->role, $this->loggedin);
        $this->id_user=$this->service->getIdUser();
        $this->role=$this->service->getRole();
    }
    public function getPageData()
    {
        header('Content-Type: text/html; charset=UTF-8');
        if ($this->loggedin)
        {
            header('location: /dashboard');

        }
        else
        {
            echo $this->template->render('Connexion.html.twig',['role'=>$this->role]);
        }

    }

    public function LogIn()
    {
        $result=$this->service->LogIn($this->email, $this->password);
        if($result!="mot de passe correct")
        {
            $Errorcontroller= new Errorcontroller($result,$this->template,$this->role);
            $Errorcontroller->getPageData();
        }
        else
        {
            header('location: /dashboard');
        }


    }

    public function LogOut()
    {
        $this->service->LogOut();
        header('location: /');
    }
}