<?php

namespace App\php\Services;


use App\php\Contenants\Commentaire;
use App\php\Repositories\Comptesrepository;
use App\php\Repositories\Daterepository;
use App\php\Repositories\Entreprisesrepository;
use App\php\Repositories\EvaluationEntreprisesrepository;
use App\php\Repositories\EvaluationPostsrepository;
use App\php\Repositories\Postsrepository;
use App\php\Services\Fiche;
use Cassandra\Time;

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
        $this->__constructrep3();

    }

    private function __constructrep3()
    {
        switch ($this->type) {
            case 3:
                $this->repository=new Postsrepository();
                $this->Evaluationrepository=new EvaluationPostsrepository($this->page,$this->limit);
                break;
            case 2:
                $this->repository=new Entreprisesrepository();
                $this->Evaluationrepository=new EvaluationEntreprisesrepository($this->page,$this->limit);
                break;
            case 1:
                $this->repository=new Comptesrepository();
                break;
        }
        $this->pagination= new Paginationservice();
    }

    private function __construct1($id_cible_,$role_,$id_user_,$type_)
    {
        $this->id_user=(int)$id_user_;
        $this->role=(string)$role_;
        $this->id_cible = (int)$id_cible_;
        $this->type=((int)$type_<1 or (int)$type_>3)?3:(int)$type_;


    }

    private function __construct2($id_cible_,$role_,$id_user_,$page_,$limit_,$type_)
    {
        $this->id_user=(int)$id_user_;
        $this->role=(string)$role_;
        $this->id_cible = (int)$id_cible_;
        $this->type=((int)$type_<1 or (int)$type_>3)?3:(int)$type_;
        $this->limit=(int)$limit_;
        $page_=(int)$page_;
        if ($page_ < 1) {
            $this->page = 1;
        }
        else{
            $this->page=$page_;
        }



    }
    public function getPageData()
    {
        $data=$this->repository->getDataByID($this->id_cible);
        if (get_class($this->repository)=="App\php\Repositories\Comptesrepository")
        {
            if(($data->getType()=="ADMIN" and $this->role=="PILOTE" ) or ($data->getType()=="PILOTE" and $this->role=="PILOTE"))
            {
                $data=null;
            }
        }
        return $data;
    }

    public function getCommentaire()
    {
        if ($this->Evaluationrepository!=null)
        {
            return $this->Evaluationrepository->getCommentaire($this->id_cible);
        }
        return null;

    }

    public function setCommentaire($Commentaire)
    {
        if ($this->Evaluationrepository!=null)
        {
            $compterepo=new Comptesrepository();
            $daterepo=new Daterepository();
            $nom=$compterepo->getNom($this->id_user);
            $prenom=$compterepo->getPrenom($this->id_user);
            $com=$Commentaire->getCommentaire();
            $note=$Commentaire->getNote();
            $current_datetime = date('Y-m-d');


            if($daterepo->checkDate($current_datetime))
            {
                $iddate=$daterepo->getIdByDate($current_datetime);
            }
            else
            {
                $daterepo->InsertData($current_datetime);
                $iddate=$daterepo->getLastInsertedId();
            }

            $commentaire= new commentaire(
                "",
                $note,
                $com,
                $nom,
                $prenom,
                $this->id_user,
                $iddate,
                $this->id_cible
            );
            return $this->Evaluationrepository->InsertData($commentaire);
        }
        return null;
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