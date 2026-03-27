<?php

namespace App\php\Services;

use App\php\Repositories\Comptesrepository;
use App\php\Repositories\Entreprisesrepository;
use App\php\Repositories\Postsrepository;
use App\php\Repositories\Wishlistrepository;


class Statservice
{

    private $limit;

    private $id_user;

    private $role;
    private $Compterepository;

    private $Entrepriserepository;

    private $Postrepository;

    private $Wishlistrepository;


    public function __construct()
    {
        $this->Entrepriserepository= new Entreprisesrepository();
        $this->Postrepository= new Postsrepository();
        $num=func_num_args();
        switch ($num){
            case 3:
                $this->__construct2(func_get_arg(0),func_get_arg(1),func_get_arg(2));
                break;
            default:
                $this->Compterepository= new Comptesrepository();
                break;
        }
    }

    private function __construct2($limit, $role_,$id_user_)
    {
        $this->limit=$this->limit <=0?5:(int)$limit;
        $this->id_user=(int)$id_user_;
        $this->role=(string)$role_;
        $this->Wishlistrepository= new Wishlistrepository($this->id_user,);
        $this->Compterepository=new Comptesrepository($this->role,$this->id_user,$this->limit);
    }

    public function getTrendingPosts()
    {
        return $this->Postrepository->getTrendingPosts();
    }

    public function getNbposts()
    {
        return $this->Postrepository->getNbPosts();
    }

    public function getNbMoyCandidature()
    {
        return $this->Postrepository->getNbMoyCandidature();
    }

    public function getMostWishPosts()
    {
        return $this->Postrepository->getMostWishPosts();
    }

    public function getNbEntreprises()
    {
        return $this->Entrepriserepository->getNbEntreprises();
    }

    public function getNbUsers()
    {
        return $this->Compterepository->getNbComptes();
    }

    public function getStudentByPostulation()
    {
        if($this->role=="PILOTE")
        {
            return $this->Compterepository->getStudentByPostulation();
        }
        else
        {
            return ["ACCES PILOTE UNIQUEMENT"];
        }
    }

    public function getNbWishes()
    {
        if($this->role=="ETUDIANT")
        {
            return $this->Wishlistrepository->getNbWishes();
        }
        return ["ACCES ETUDIANT UNIQUEMENT"];
    }
}