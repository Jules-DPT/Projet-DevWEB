<?php

namespace App\php\Services;

use App\php\Repositories\Postsrepository;
use App\php\Repositories\Entreprisesrepository;
use App\php\Repositories\Comptesrepository;

require_once 'Service.php';

class Recherchesservice extends Service
{

    public function __construct($page,$int,$recherche)
    {
        if ($page < 1) {
            $page = 1;
        }
        $recherche=htmlspecialchars($recherche);
        $recherche='%'.$recherche.'%';
        switch ($int){
            case 1:
                $this->repository = new Comptesrepository($page,12,$recherche);
                break;
            case 2:
                $this->repository = new EntreprisesRepository($page,12,$recherche);
                break;
            case 3:
                $this->repository = new PostsRepository($page,12,$recherche);
                break;
        }
    }

    public function getPrimaryData()
    {
        return $this->repository->getPrimaryData();
    }



}