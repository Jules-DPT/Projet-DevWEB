<?php

namespace App\php\Repositories;

use App\php\Contenants\Commentaire;
use App\php\Repositories\Repository;

class EvaluationEntreprisesrepository extends Repository
{

    public function DeleteDataByID($id_)
    {
        // TODO: Implement DeleteDataByID() method.
    }

    public function UpdateDataByID($id_, $contenant_)
    {
        // TODO: Implement UpdateDataByID() method.
    }

    public function InsertData($contenant_)
    {
        $id=$contenant_->getId();
        $note=$contenant_->getNote();
        $date=$contenant_->getDate();
        $commentaire=$contenant_->getCommentaire();
        $id_user=$contenant_->getIdUser();
        $id_cible=$contenant_->getIdCible();
        $query="Insert into evaluation_entreprise(id, note, commentaire, id_utilisateur, id_entreprise, id_date) 
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

    public function getDataByID($id_)
    {
        $query="select ee.id,note,commentaire,u.nom,u.prenom,u.id as id_user,date,ee.id_entreprise from evaluation_entreprise ee
                left join bdd_web.utilisateur u on u.id = ee.id_utilisateur
                left join bdd_web.date d on d.id = ee.id_date
                where id_entreprise=?";
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
            $data['id_entreprise']
        );
        $result->close();
        return $commentaire;
    }


}