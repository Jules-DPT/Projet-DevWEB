<?php

namespace App\php\Repositories;

use App\php\Contenants\Compte;
use App\php\Repositories\Repository;

class Comptesrepository extends Rechercherepository
{

    private $limit = 12;
    private $page;
    private $offset;
    private $recherche;
    private $role;
    private $id_user;
    public function __construct()
    {
        $this->autoSQL();
        $num = func_num_args();
        switch ($num) {
            case 5: $this->__construct2(func_get_arg(0), func_get_arg(1),func_get_arg(2),func_get_arg(3),func_get_arg(4)); break;
        }

    }



    private function __construct2($page_, $limit_, $recherche_,$role_,$id_user_):void
    {
        $this->role = $role_;
        $this->id_user = $id_user_;
        $this->page = $page_;
        $this->limit = $limit_ >= 0 ? $limit_ : $this->limit;
        $this->offset = ($this->page - 1) * $this->limit;
        $this->recherche = $recherche_;

    }


    protected function getWhere()
    {
        $words=explode(" ",trim($this->recherche));
        if ($this->role=="PILOTE"){
            $where=" WHERE t.type!='ADMIN' and t.type!='PILOTE' and id_pilote='$this->id_user'";
        }
        else{
            $where = "";
        }
        if (!empty($words) && $words[0] !== "") {
            $rec = [];
            foreach ($words as $word) {
                $rec[] = "CONCAT(utilisateur.id, ' ', utilisateur.nom, ' ', utilisateur.prenom,' ',t.type,' ',promo) LIKE '%".$word."%'";
            }
            if ($this->role=="PILOTE"){
                $where = "WHERE " . implode(" AND ", $rec)." AND t.type!='ADMIN' and t.type!='PILOTE' ";
            }
            else
            {
                $where = "WHERE " . implode(" AND ", $rec);
            }

        }
        return $where;
    }
    public function getPage()
    {
        return $this->page;
    }
    public function getPageData()
    {
        $where = $this->getWhere();
        $query = "select utilisateur.id as id,utilisateur.nom as nom,utilisateur.prenom as prenom,t.type as type,promo,f.chemin as file
                    from bdd_web.utilisateur
                    left join bdd_web.file f on f.id = utilisateur.id_chemin
                    left join bdd_web.type_utilisateur t on utilisateur.id_type = t.id
                    $where
                    ORDER BY nom ASC LIMIT ? OFFSET ?  ";
        $result = $this->getSearchData($query, $this->limit, $this->offset);
        $comptes = [];
        while ($data = $result->fetch_assoc()) {
            $comptes[] =
                new Compte(
                    (int)$data['id'],
                    $data['nom'],
                    $data['prenom'],
                    "",
                    $data['type'],
                    $data['file'],
                    "",
                    $data['promo'],
                    "",
                    "",
                    ""
                );
        }
        $result->close();
        return $comptes;
    }

    public function getALLCount()
    {
        $where = $this->getWhere();
        $query="select count(utilisateur.id) as nb
                    from bdd_web.utilisateur
                    left join bdd_web.file f on f.id = utilisateur.id_chemin
                    left join bdd_web.type_utilisateur t on utilisateur.id_type = t.id
                    $where
                    ORDER BY nom ASC " ;
        $row =$this->SQL->prepare($query);
        $row->execute();
        $result = $row->get_result();
        $data = $result->fetch_assoc();
        $result->close();
        if ($data==null){
            $data['nb']=1;
        }
        return (int)$data['nb'];
    }

    public function UpdateDataByID($id_, $Compte_)
    {

    }

    public function UpdatePassByID($id_, $Password_){
        $query="update bdd_web.utilisateur set mot_de_passe=? where id=?";
        $this->SQL->bind_param("si", $Password_, $id_);
        $row=$this->SQL->prepare($query);
        $row->execute();
        $result=$row->get_result();
        $data=$result->fetch_assoc();
        $result->close();
        if ($data==null){
            return false;
        }
        return true;
    }

    public function getPassByID($id_){
        $query="select mot_de_passe from bdd_web.utilisateur where id=?";
        $result=$this->ExecuteQueryByID($query, $id_);
        $data = $result->fetch_assoc();
        $result->close();
        return $data['mot_de_passe'];

    }

    public function getIdByEmail($email)
    {
        $query="select utilisateur.id as ID from bdd_web.utilisateur 
                left join bdd_web.email e on e.id = utilisateur.id_email where e.email=?";
        $this->SQL->bind_param("s", $email);
        $row=$this->SQL->prepare($query);
        $row->execute();
        $data = $row->get_result();
        $result=$data->fetch_assoc();
        $result->close();
        if ($data==null){
            return false;
        }
        return (int)$result['ID'];
    }

    public function getRoleById($id_)
    {
        $query="select t.type from bdd_web.utilisateur 
                left join type_utilisateur t on utilisateur.id_type = t.id where utilisateur.id=?";
        $result=$this->ExecuteQueryByID($query, $id_);
        $data = $result->fetch_assoc();
        $result->close();
        return $data['type'];
    }

    public function UpdateTypeById($id_,$id_Type)
    {
        $query="update bdd_web.utilisateur set id_type=? where id=?";
        $this->SQL->bind_param("ii", $id_Type, $id_);
        $row=$this->SQL->prepare($query);
        $row->execute();
        $result=$row->get_result();
        if($result->num_rows==1){
            return true;
        }
        return false;
    }

    public function getNbComptes()
    {
        $query="select count(utilisateur.id) as nb from bdd_web.utilisateur";
        $row=$this->SQL->prepare($query);
        $row->execute();
        $result = $row->fetch_assoc();
        $result->close();
        return (int)$result['nb'];
    }
}