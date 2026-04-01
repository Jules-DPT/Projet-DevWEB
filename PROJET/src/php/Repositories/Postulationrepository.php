<?php

namespace App\php\Repositories;

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
        // TODO: Implement getDataByID() method.
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
}