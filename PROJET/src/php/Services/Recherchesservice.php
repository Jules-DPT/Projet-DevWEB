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
    public function __construct($page_,$int,$recherche)
    {
        $page_=(int)$page_;
        if ($page_ < 1) {
            $this->page = 1;
        }
        else{
            $this->page=$page_;
        }
        $recherche=htmlspecialchars($recherche);
        $this->limit=12;
        switch ($int){
            case 1:
                $this->repository = new Comptesrepository($this->page,$this->limit,$recherche);
                break;
            case 2:
                $this->repository = new EntreprisesRepository($this->page,$this->limit,$recherche);
                break;
            case 3:
                $this->repository = new PostsRepository($this->page,$this->limit,$recherche);
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
        $this->totalPages = ceil($this->repository->getSecondaryData()/$this->limit);
        return  $this->totalPages ;
    }


    public function getPath($get_)
    {
        return $this->pagination->getPath(htmlspecialchars($get_));
    }
    public function getPage()
    {
        return $this->page;
    }
}