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
            case 3:
                $this->__construct1(func_get_arg(0),func_get_arg(1),func_get_arg(2));
                break;
            case 5:
                $this->__construct2(func_get_arg(0), func_get_arg(1),func_get_arg(2),func_get_arg(3),func_get_arg(4));
                break;
        }

    }

    private function __construct1($role_,$id_user_,$limit_)
    {
        $this->role = $role_;
        $this->id_user = $id_user_;
        $this->limit = $limit_ >= 0 ? (int)$limit_ : $this->limit;
    }

    private function __construct2($page_, $limit_, $recherche_,$role_,$id_user_):void
    {
        $this->role = $role_;
        $this->id_user = $id_user_;
        $this->page = $page_;
        $this->limit = $limit_ >= 0 ? (int)$limit_ : $this->limit;
        $this->offset = ($this->page - 1) * $this->limit;
        $this->recherche = $recherche_;

    }


    protected function getWhere()
    {
        /*
         * Récupère (return) la clause where SQL spécialement assemblé avec la recherche et les colonnes du compte
         */
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
        /*
         * retourne un array de compte selon le where de la recherche (pour la page recherche)
         */
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
        /*
         * Récupère le total de Comptes associée a une recherche
         */
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

    public function InsertData($Compte_)
    {
        $nom=$Compte_->getNom();
        $prenom=$Compte_->getPrenom();
        $type=$Compte_->getType();
        $file=4;
        $mdp=$Compte_->getPassword();
        $idpilote=$Compte_->getIdPilote();
        $promo=$Compte_->getPromo();
        $email=$Compte_->getEmail();
        $telephone=$Compte_->getTelephone();
        $snake=$Compte_->getSnakeScore();

        $query = "insert into bdd_web.utilisateur 
        (nom, prenom, mot_de_passe, id_type, id_chemin, id_pilote, promo, id_email, id_telephone, snake_score)
        VALUES(?,?,?,?,?,?,?,?,?,?)";
        $row=$this->SQL->prepare($query);
        $row->bind_param("sssiiisiii",$nom,$prenom,$mdp,$type,$file,$idpilote,$promo,$email,$telephone,$snake);
        $row->execute();
        if($row->affected_rows>0){
            $row->close();
            return true;
        }
        $row->close();
        return false;

    }

    public function UpdatePassByID($id_, $Password_){
        /*
         * met a jour le mot de passe d'un utilisateur
         */
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
        /*
         * Récupère le mot de passe d'un utilisateur
         */
        $query="select mot_de_passe from bdd_web.utilisateur where id=?";
        $result=$this->ExecuteQueryByID($query, $id_);
        $data = $result->fetch_assoc();
        $result->close();
        return $data['mot_de_passe'];

    }

    public function getIdByEmail($email)
    {
        /*
         * Récupère l'id utilisateur via l'email
         */
        $query="select utilisateur.id as ID from bdd_web.utilisateur 
                left join bdd_web.email e on e.id = utilisateur.id_email where e.email=?";
        $row=$this->SQL->prepare($query);
        $row->bind_param("s", $email);
        $row->execute();
        $data = $row->get_result();
        $result=$data->fetch_assoc();
        $row->close();
        if ($data==null){
            return false;
        }
        return (int)$result['ID'];
    }

    public function getRoleById($id_)
    {
        /*
         * Récupère le role utilisateur via l'id
         */
        $query="select t.type as type from bdd_web.utilisateur 
                left join type_utilisateur t on utilisateur.id_type = t.id where utilisateur.id=?";
        $result=$this->ExecuteQueryByID($query, $id_);
        $data = $result->fetch_assoc();
        $result->close();
        return $data['type'];
    }

    public function UpdateTypeById($id_,$id_Type)
    {
        /*
         * Met a jour le type via l'id
         */
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
        /*
         * Retourne le nombre total d'utilisateur
         */
        $query="select count(utilisateur.id) as nb from bdd_web.utilisateur";
        $row=$this->SQL->prepare($query);
        $row->execute();
        $result = $row->get_result();
        $data = $result->fetch_assoc();
        $row->close();
        return (int)$data['nb'];
    }

    public function getStudentByPostulation()
    {
        /*
         * Retourne des comptes étudiant associé au pilote (les classes par nb postulation)
         */
        $query="select count(p.id) as nb,u.id ,u.nom,u.prenom,U.promo
                from postulation p
                         left join utilisateur u on u.id = p.id_utilisateur
                where u.id_pilote=?
                group by u.id order by nb DESC LIMIT ?";
        $row =$this->SQL->prepare($query);
        $row->bind_param("ii",$this->id_user,$this->limit);
        $row->execute();
        $result = $row->get_result();
        $stat=[];
        while ($data = $result->fetch_assoc()) {
            $stat[]=["id"=>$data["id"],"nom"=>$data["nom"],"prenom"=>$data["prenom"],"promo"=>$data["promo"],"nb"=>$data["nb"]];
        }
        $result->close();
        return $stat;
    }

    public function getDataByID($id_)
    {
        $query="select u.id as id,u.nom as nom,u.prenom as prenom,t.type as type,promo,f.chemin as file,
                   t2.numero,p.prefix_tel,email,snake_score,(select nom from utilisateur u2 where u2.id=u.id_pilote) as pnom,
                   (select prenom from utilisateur u2 where u2.id=u.id_pilote) as pprenom
            from bdd_web.utilisateur u
                     left join bdd_web.file f on f.id = u.id_chemin
                     left join bdd_web.type_utilisateur t on u.id_type = t.id
                     left join bdd_web.email on u.id_email = email.id
                     left join bdd_web.telephone t2 on u.id_telephone = t2.id
                     left join bdd_web.pays p on t2.id_pays = p.id
            where u.id=? ";
        $result=$this->ExecuteQueryByID($query, $id_);
        $data = $result->fetch_assoc();
        $result->close();
        if ($data==null){
            return null;
        }
        $compte=new Compte(
            (int)$data["id"],
            $data["nom"],
            $data["prenom"],
            "",
            $data["type"],
            $data["file"],
            $data["pprenom"]." ".$data["pnom"],
            $data["promo"],
            $data["email"],
            $data["numero"],
            $data["snake_score"]
        );
        return $compte;
    }

    public function getDataByRole($Role)
    {
        $query="select u.id as id,u.nom as nom,u.prenom as prenom,t.type as type,promo,f.chemin as file,
                       t2.numero,p.prefix_tel,email,snake_score
                from bdd_web.utilisateur u
                         left join bdd_web.file f on f.id = u.id_chemin
                         left join bdd_web.type_utilisateur t on u.id_type = t.id
                         left join bdd_web.email on u.id_email = email.id
                         left join bdd_web.telephone t2 on u.id_telephone = t2.id
                         left join bdd_web.pays p on t2.id_pays = p.id
                where t.type=?";
        $row =$this->SQL->prepare($query);
        $row->bind_param("s",$Role);
        $row->execute();
        $result=$row->get_result();
        $comptes=[];
        while ($data = $result->fetch_assoc()) {
            $compte=new Compte(
                (int)$data["id"],
                $data["nom"],
                $data["prenom"],
                "",
                $data["type"],
                $data["file"],
                "",
                $data["promo"],
                $data["email"],
                $data["numero"],
                $data["snake_score"]
            );
        }
        $result->close();
        return $comptes;
    }

    public function getNom($id_)
    {
        $query="select nom from bdd_web.utilisateur where id=?";
        $result = $this->executeQueryByID($query, $id_);
        $data = $result->fetch_assoc();
        $result->close();
        return (string)$data["nom"];
    }

    public function getPrenom($id_)
    {
        $query="select prenom from bdd_web.utilisateur where id=?";
        $result = $this->executeQueryByID($query, $id_);
        $data = $result->fetch_assoc();
        $result->close();
        return (string)$data["prenom"];
    }
}