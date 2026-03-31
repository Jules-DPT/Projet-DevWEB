<?php

namespace App\php\Services;

use App\php\Repositories\Postsrepository;
use App\php\Services\Service;

class Postsservice extends Service
{
    public function __construct()
    {
        $this->repository = new Postsrepository();
    }

    public function checkPosts($id_cible)
    {
         if($this->repository->getNbpostByEntreprise($id_cible)>0)
         {
             return true;
         }
         return false;
    }
}