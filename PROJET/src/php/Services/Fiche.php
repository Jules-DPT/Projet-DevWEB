<?php

namespace App\php\Services;

use App\php\Contenants\Commentaire;
use App\php\Services\Service;

abstract class Fiche extends Service
{
    private $Evaluationrepository;
    private $role;
    private $id_user;
    private $id_cible;
    protected function getPageData()
    {
    }

    protected function getCommentaire()
    {
        return $this->Evaluationrepository->getDataById($this->id_cible);
    }

    protected function setCommentaire($commentaire)
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