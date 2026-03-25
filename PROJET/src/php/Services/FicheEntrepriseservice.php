<?php

namespace App\php\Services;

use App\php\Contenants\Commentaire;
use App\php\Repositories\Entreprisesrepository;
use App\php\Repositories\EvaluationEntreprisesrepository;
use App\php\Services\Fiche;


class FicheEntrepriseservice extends Fiche
{


    public function __construct($id_entreprise_,$role_,$id_user_)
    {
        $this->id_user=$id_user_;
        $this->role=$role_;
        $this->id_cible = $id_entreprise_;
        $this->repository=new Entreprisesrepository();
        $this->Evaluationrepository=new EvaluationEntreprisesrepository();
    }
    public function getPageData()
    {
        return $this->repository->getEntreprisebyid($this->id_cible);
    }

    public function getCommentaire()
    {
        return $this->getCommentaire();
    }

    public function setCommentaire($commentaire)
    {
        return $this->setCommentaire($commentaire);
    }


}