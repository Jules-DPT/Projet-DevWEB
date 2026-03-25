<?php

namespace App\php\Repositories;

use App\php\Contenants\Commentaire;
use App\php\Repositories\Repository;

class EvaluationPostsrepository extends Repository
{

    protected function DeleteDataByID($id_)
    {
        // TODO: Implement DeleteDataByID() method.
    }

    protected function UpdateDataByID($id_, $contenant_)
    {
        // TODO: Implement UpdateDataByID() method.
    }

    protected function InsertData($contenant_)
    {
        $id=$contenant_->getId();
        $note=$contenant_->getNote();
        $date=$contenant_->getDate();
        $commentaire=$contenant_->getCommentaire();
        $id_user=$contenant_->getIdUser();
        $id_cible=$contenant_->getIdCible();
        $query="Insert into evaluation_posts(id, note, commentaire, id_utilisateur, id_post, id_date) 
                values(?,?,?,?,?,?)";
        $this->SQL->bind_param("idsiis",$id,$note,$commentaire,$id_user,$id_cible,$date);
        $row=$this->SQL->execute($query);
        $result=$row->get_result();
        if ($result->affected_rows ==1) {
            $result->close();
            return true;
        }
        $result->close();
        return false;
    }

    protected function getDataByID($id_)
    {
        $query="select es.id,note,commentaire,u.nom,u.prenom,u.id as id_user,date,es.id_post from evaluation_posts es
                left join bdd_web.utilisateur u on u.id = es.id_utilisateur
                left join bdd_web.date d on d.id = es.id_date
                where id_post=? ";
        $result = $this->ExecuteQueryByID($query,$id_);
        $data = $result->fetch_assoc();
        $commentaire= new Commentaire(
            (int)$data['id'],
            $data['note'],
            $data['commentaire'],
            $data['nom'],
            $data['prenom'],
            $data['id_user'],
            $data['date'],
            $data['id_post']
        );
        $result->close();
        return $commentaire;
    }
}