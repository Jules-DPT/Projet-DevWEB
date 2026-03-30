<?php

namespace App\php\Controllers;

use App\php\Controllers\Controller;
use App\php\Services\Logioservice;

class Logiocontroller extends Controller
{
    private $email;
    private $password;


    private function __construct1($id_user_,$role_,$loggedin_)
    {
        $this->id_user = $id_user_;
        $this->role = $role_;
        $this->loggedin = $loggedin_;
    }

    private function __construct2($id_user_,$role_,$loggedin_,$email_,$password_)
    {
        $this->id_user = $id_user_;
        $this->role = $role_;
        $this->loggedin = $loggedin_;
        $this->email = $email_;
        $this->password = $password_;
    }

    public function __construct()
    {
        session_start();

        $num=func_num_args();
        switch ($num) {
            case 3:
                $this->__construct1(func_get_arg(0), func_get_arg(1),func_get_arg(2)); break;
            case 5:
                $this->__construct2(func_get_arg(0), func_get_arg(1),func_get_arg(2),
                    func_get_arg(3),func_get_arg(4)); break;
        }
        $this->service = new Logioservice($this->id_user, $this->role, $this->loggedin);
        $this->id_user=$this->service->getIdUser();
        $this->role=$this->service->getRole();
    }
    public function getPageData()
    {
        if ($this->loggedin)
        {
            echo $this->template->render('dashboard.html.twig',['role'=>$this->role,]);
        }
        else
        {
            echo $this->template->render('/connexion.html.twig', []);
        }

    }
}