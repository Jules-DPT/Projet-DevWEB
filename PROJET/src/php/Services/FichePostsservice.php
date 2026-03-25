<?php

namespace App\php\Services;


use App\php\Repositories\EvaluationPostsrepository;
use App\php\Repositories\Postsrepository;
use App\php\Services\Fiche;

class FichePostsservice extends Fiche
{
    public function __construct($id_post_,$role_,$id_user_)
    {
        $this->id_user=$id_user_;
        $this->role=$role_;
        $this->id_cible = $id_post_;
        $this->repository=new Postsrepository();
        $this->Evaluationrepository=new EvaluationPostsrepository();
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
}