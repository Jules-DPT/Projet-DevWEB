<?php

namespace App\php\Services;

use App\php\Contenants\Commentaire;
use App\php\Repositories\Entreprisesrepository;
use App\php\Repositories\EvaluationEntreprisesrepository;
use App\php\Services\Service;


class FicheEntrepriseservice extends Service
{
    private $id_entreprise;
    private $Evaluationrepository;

    private $role;
    private $id_user;
    public function __construct($id_entreprise_,$role_,$id_user_)
    {
        $this->id_user=$id_user_;
        $this->role=$role_;
        $this->id_entreprise = $id_entreprise_;
        $this->repository=new Entreprisesrepository();
        $this->Evaluationrepository=new EvaluationEntreprisesrepository();
    }
    public function getPageData()
    {
        return $this->repository->getEntreprisebyid($this->id_entreprise);
    }

    public function getCommentaire()
    {
        return $this->Evaluationrepository->getDataById($this->id_entreprise);
    }

    public function setCommentaire($commentaire)
    {
        $id=(int)$commentaire->getID();
        $note=(float)$commentaire->getNote();
        $com=trim((string)$commentaire->getCommentaire());
        $id_user=$this->id_user;
        $date=date('Y-m-d'); //automatic date
        $id_cible=(int)$commentaire->getIdCible();
        if ($id==null or $note==null or $com==null or $id_user==null or $date==null or $id_cible==null)
        {
            return false;
        }
        elseif($this->role=="ETUDIANT" or $this->role=="NO")
        {
            return false;
        }
        $com= new Commentaire(
            $id,
            $note,
            $com,
            "",
            "",
            $id_user,
            $date,
            $id_cible
        );
        return $this->Evaluationrepository->InsertData($com);
    }

}