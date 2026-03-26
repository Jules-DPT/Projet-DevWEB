<?php

namespace App\php\Repositories;

use App\php\Contenants\Commentaire;
use App\php\Repositories\Repository;

class EvaluationPostsrepository extends Repository
{

    private $limit;
    private $offset;
    private $page;

    public function __construct()
    {
        $this->autoSQL();
        $num=func_num_args();
        switch ($num) {
            case 0:
                break;
            case 2:
                $this->__construct1(func_num_args(0),func_get_arg(1));
                break;
        }
    }

    private function __construct1($page_,$limit_){
        $this->page=$page_;
        $this->limit=$limit_;
        $this->offset = ($this->page - 1) * $this->limit;
    }

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
        $note=$contenant_->getNote();
        $date=$contenant_->getDate();
        $commentaire=$contenant_->getCommentaire();
        $id_user=$contenant_->getIdUser();
        $id_cible=$contenant_->getIdCible();
        $query="Insert into evaluation_posts( note, commentaire, id_utilisateur, id_post, id_date) 
                values(?,?,?,?,?)";
        $this->SQL->bind_param("dsiis",$note,$commentaire,$id_user,$id_cible,$date);
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
        $query="select es.id as id,note,commentaire,u.nom,u.prenom,u.id as id_user,date,es.id_post from evaluation_posts es
                left join bdd_web.utilisateur u on u.id = es.id_utilisateur
                left join bdd_web.date d on d.id = es.id_date
                where es.id=? ";
        $result = $this->ExecuteQueryByID($query,$id_);
        $commentaire=[];
        while ($data = $result->fetch_assoc()) {
            $commentaire = new Commentaire(
                (int)$data['id'],
                $data['note'],
                $data['commentaire'],
                $data['nom'],
                $data['prenom'],
                $data['id_user'],
                $data['date'],
                $data['id_post']
            );
        }
        $result->close();
        return $commentaire;
    }

    public function getCommentaire($id_)
    {
        $query="select es.id,note,commentaire,u.nom,u.prenom,u.id as id_user,date,es.id_post from evaluation_posts es
                left join bdd_web.utilisateur u on u.id = es.id_utilisateur
                left join bdd_web.date d on d.id = es.id_date
                where id_post=? ORDER BY date ASC LIMIT ? OFFSET ?  ";
        $row =$this->SQL->prepare($query);
        $row->bind_param("iii",$id_,$this->limit,$this->offset);
        $row->execute();
        $result = $row->get_result();
        $commentaire=[];
        while ($data = $result->fetch_assoc()) {
            $commentaire[] = new Commentaire(
                (int)$data['id'],
                $data['note'],
                $data['commentaire'],
                $data['nom'],
                $data['prenom'],
                $data['id_user'],
                $data['date'],
                $data['id_post']
            );
        }
        $result->close();
        return $commentaire;
    }


}