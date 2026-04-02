<?php

namespace App\php\Services;

use App\php\Contenants\Commentaire;
use App\php\Repositories\Comptesrepository;
use App\php\Services\Service;

class Compteservice extends Service
{
    private $role;
    private $id_user;
    public function __construct($role_,$id_user_)
    {

        $this->role =$role_==null?"NO": (string)$role_;
        $this->id_user = (int)$id_user_;
        $this->repository=new Comptesrepository($this->role,$this->id_user,0);
    }

    public function getCompte()
    {
        if ($this->role=="ADMIN" or $this->role=="PILOTE" or $this->role=="ETUDIANT")
        {
            return $this->repository->getDataByID($this->id_user);
        }
        return null;
    }
}