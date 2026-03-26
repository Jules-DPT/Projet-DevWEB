<?php

namespace App\php\Services;


use App\php\Repositories\Entreprisesrepository;
use App\php\Repositories\EvaluationEntreprisesrepository;
use App\php\Repositories\EvaluationPostsrepository;
use App\php\Repositories\Postsrepository;
use App\php\Services\Fiche;

class Ficheservice extends Fiche
{
    private $limit;
    private $page;

    private $pagination;
    private $type;
    public function __construct()
    {
        $this->limit = 4;
        $this->page = 1;
        $num=func_num_args();
        switch ($num) {
            case 4:
                $this->__construct1(func_get_arg(0),func_get_arg(1),func_get_arg(2),func_get_arg(3));
                break;
            case 6:
                $this->__construct2(func_get_arg(0),func_get_arg(1),func_get_arg(2),func_get_arg(3),func_get_arg(4),func_get_arg(5));
        }

    }

    private function __constructrep3()
    {
        switch ($this->type) {
            case 1:
                $this->repository=new Postsrepository();
                $this->Evaluationrepository=new EvaluationPostsrepository($this->page,$this->limit);
                break;
            case 2:
                $this->repository=new Entreprisesrepository();
                $this->Evaluationrepository=new EvaluationEntreprisesrepository($this->page,$this->limit);
                break;
        }
    }

    private function __construct1($id_cible_,$role_,$id_user_,$type_)
    {
        $this->id_user=(int)$id_user_;
        $this->role=(string)$role_;
        $this->id_cible = (int)$id_cible_;
        $this->type=(int)$type_;
        $this->__constructrep3();


    }

    private function __construct2($id_cible_,$role_,$id_user_,$page_,$limit_,$type_)
    {
        $this->id_user=(int)$id_user_;
        $this->role=(string)$role_;
        $this->id_cible = (int)$id_cible_;
        $this->type=(int)$type_;
        $this->limit=(int)$limit_;
        $page_=(int)$page_;
        if ($page_ < 1) {
            $this->page = 1;
        }
        else{
            $this->page=$page_;
        }
        $this->pagination= new Paginationservice();
        $this->__constructrep3();

    }
    public function getPageData()
    {
        return $this->repository->getDataByID($this->id_cible);
    }

    public function getCommentaire()
    {
        return $this->getCommentaire();
    }

    public function setCommentaire($commentaire)
    {
        return $this->setCommentaire($commentaire);
    }

    public function getTotalPages()
    {
        return $this->getTotal($this->Evaluationrepository->getCommentaire($this->id_cible), $this->limit);
    }

    public function getType()
    {
        return $this->type;
    }
    public function getLimit()
    {
        return $this->limit;
    }
    public function getPath($get_)
    {
        return $this->pagination->getPath($get_);
    }

    public function getPage()
    {
        return $this->page;
    }

    public function getIdCible()
    {
        return $this->id_cible;
    }

    public function getIdUser()
    {
        return $this->id_user;
    }
    public function getRole()
    {
        return $this->role;
    }
}