<?php

namespace App\php\Repositories;

use App\php\Contenants\Postulation;
use App\php\Repositories\Repository;

class Postulationrepository extends Repository
{

    public function __construct()
    {
        $this->autoSQL();
    }
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
        $id_user = $contenant_->getIdUtilisateur();
        $id_post = $contenant_->getIdPost();
        $LM= $contenant_->getLM();
        $idfile=$contenant_->getFile();
        $query="Insert into postulation (lm, id_cv, id_utilisateur, id_post) values (?,?,?,?)";
        $row=$this->SQL->prepare($query);
        $row->bind_param('siii',$LM,$idfile,$id_user,$id_post);
        $row->execute();
        if($row->affected_rows > 0){
            return true;
        }
        return false;
    }

    public function getDataByID($id_)
    {
        $query="Select po.id as id,LM, id_cv as CV, prenom,nom, titre 
                from postulation po
                left join utilisateur u on u.id=po.id_utilisateur
                left join posts p on p.id=po.id_post
                left join file f on f.id=po.id_cv
                where id_utilisateur=?";
        $result=$this->ExecuteQueryByID($query,$id_);
        $postulation=new Postulation(
            $result["id"],
            $result["prenom"]." ".$result["nom"],
            $result["titre"],
            $result["CV"],
            $result["LM"]
        );
        return $postulation;
    }

    public function checkPostulation($id_post,$id_user)
    {
        $query="select * from postulation where id_post=? and id_utilisateur=?";
        $row=$this->SQL->prepare($query);
        $row->bind_Param("ii",$id_post,$id_user);
        $row->execute();
        $result =$row->get_result();
        $data=$result->fetch_assoc();
        if ($data === null) {
            $result->close();
            return false;
        }
        $result->close();
        return true;
    }

    public function getPostulationInfoById($id_)
    {
        $query="Select LM, prenom,nom, titre 
                from postulation po
                left join utilisateur u on u.id=po.id_utilisateur
                left join posts p on p.id=po.id_post
                where id_utilisateur=?";
        $result=$this->ExecuteQueryByID($query,$id_);
        $postulation=new Postulation(
            "",
            $result["prenom"]." ".$result["nom"],
            $result["titre"],
            "",
            $result["LM"]
        );
        return $postulation;
    }
}