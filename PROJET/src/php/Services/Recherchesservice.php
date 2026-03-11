<?php

namespace php\Services;

use php\Repositories\Postsrepository;
use php\Repositories\Entreprisesrepository;
use php\Repositories\Comptesrepository;



class Recherchesservice extends Service
{

    public function __construct($page,$int)
    {
        switch ($int){
            case 1:
                $this->repository = new Comptesrepository($page,12);
                break;
            case 2:
                $this->repository = new EntreprisesRepository($page,12);
                break;
            case 3:
                $this->repository = new PostsRepository($page,12);
                break;
        }

    }



    public function getPrimaryData()
    {
        return $this->repository->getPrimaryData();
    }



}