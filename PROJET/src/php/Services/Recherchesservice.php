<?php

namespace App\php\Services;

use App\php\Repositories\Postsrepository;
use App\php\Repositories\Entreprisesrepository;
use App\php\Repositories\Comptesrepository;
use App\php\Services\Paginationservice;

require_once 'Service.php';

class Recherchesservice extends Service
{

    private $pagination;
    private $limit;
    private $page;

    private $totalPages;

    private $id_user;
    private $role;
    private $postulationservice;
    private $type;

    private $recherche;
    public function __construct($page_,$int,$recherche_,$role_,$id_user_)
    {
        if($int===null){
            $int=3;
        }
        elseif($int>3 or $int<1){
            $int=3;
        }
        else{
            $int=(int)$int;
        }
        echo $int;
        $this->role=(string)$role_;
        $this->id_user=(int)$id_user_;
        if(($this->role=="ETUDIANT" or $this->role=="NO") ) {
            if($int == 1) {
                $int=3;
            }
        }
        $this->type=$int;
        $page_=(int)$page_;
        if ($page_ < 1) {
            $this->page = 1;
        }
        else{
            $this->page=$page_;
        }
        $this->recherche=htmlspecialchars($recherche_);
        $this->limit=1;
        switch ($this->type){
            case 1:
                $this->repository = new Comptesrepository($this->page,$this->limit,$this->recherche,$this->role,$this->id_user);
                break;
            case 2:
                $this->repository = new EntreprisesRepository($this->page,$this->limit,$this->recherche);
                break;
            case 3:
                $this->repository = new PostsRepository($this->page,$this->limit,$this->recherche);
                $this->postulationservice= new Postulationservice();
                break;
        }
        $this->pagination= new Paginationservice();
    }

    public function getPageData()
    {
        return $this->repository->getPageData();
    }

    public function getTotalPages()
    {
        $this->totalPages = ceil($this->repository->getALLCount()/$this->limit);
        return  $this->totalPages ;
    }

    public function getPath($get_)
    {
        return $this->pagination->getPath($get_);
    }

    public function getPage()
    {
        return $this->page;
    }

    public function getType()
    {
        return $this->type;
    }
    public function getLimit()
    {
        return $this->limit;
    }
    public function getRecherche()
    {
        return $this->recherche;
    }
}