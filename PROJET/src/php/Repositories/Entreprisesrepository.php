<?php

namespace App\php\Repositories;

use App\php\Contenants\Entreprise;
use App\php\Repositories\Repository;
require_once 'Repository.php';

class Entreprisesrepository extends Rechercherepository
{
    private $limit = 12;
    private $page;
    private $offset;

    private $recherche;
    public function __construct()
    {
        $this->autoSQL();
        $num = func_num_args();
        switch ($num) {
            case 3: $this->__construct2(func_get_arg(0), func_get_arg(1),func_get_arg(2)); break;
        }

    }



    private function __construct2($page_, $limit_, $recherche_):void
    {
        $this->page = $page_;
        $this->limit = $limit_ >= 0 ? $limit_ : $this->limit;
        $this->offset = ($this->page - 1) * $this->limit;
        $this->recherche = $recherche_;
    }

    protected function getWhere()
    {
        $words=explode(" ",trim($this->recherche));
        $where = "";
        if (!empty($words) && $words[0] !== "") {
            $rec = [];
            foreach ($words as $word) {
                $rec[] = "CONCAT(entreprise.nom, ' ', entreprise.descritption,' ',v.nom,' ',v.code_postal) LIKE '%".$word."%'";
            }
            $where = "WHERE " . implode(" AND ", $rec);
        }
        return $where;
    }

    public function getPageData()
    {
        $where = $this->getWhere();
        $query="select entreprise.id as id, entreprise.nom as nom,CONCAT(SUBSTRING_INDEX(entreprise.descritption,' ',30), '...') AS description_pointille,
                       v.nom as ville,f.chemin as file
                from bdd_web.entreprise
                left JOIN bdd_web.file f on f.id = entreprise.id_logo
                left JOIN bdd_web.adresse a ON entreprise.id_adresse = a.id
                left JOIN bdd_web.ville v ON a.id_ville = v.id
                $where
                ORDER BY entreprise.nom ASC LIMIT ? OFFSET ? ";
        $result = $this->getSearchData($query,$this->limit,$this->offset);
        $Entreprises=[];
        while ($data = $result->fetch_assoc()) {
            $Entreprises[]= new Entreprise(
                (int)$data['id'],
                $data['nom'],
                "",
                $data['ville'],
                "",
                "",
                $data['description_pointille'],
                '',
                $data['file']==null ? "" : $data['file'],
                '',
                $this->getMoyNote((float)$data['id']),
                $this->getNbPosts((int)$data['id'])
            );

        }
        $result->close();
        return $Entreprises;
    }

    public function getALLCount()
    {
        $where = $this->getWhere();
        $query="select count(entreprise.id) as nb
                from bdd_web.entreprise
                left JOIN bdd_web.file f on f.id = entreprise.id_logo
                left JOIN bdd_web.adresse a ON entreprise.id_adresse = a.id
                left JOIN bdd_web.ville v ON a.id_ville = v.id
                $where
                ORDER BY entreprise.nom ASC ";
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

    public function getAlldata()
    {

    }

    public function getEntreprisebyid($id_entreprise)
    {
        $query="select entreprise.id ,entreprise.nom as nom,descritption,email,numero,chemin as file,a.adresse,v.nom as ville,v.code_postal,p.nom as pays 
                from entreprise
                left join bdd_web.file f on entreprise.id_logo = f.id
                left join bdd_web.email e on entreprise.id_email = e.id
                left join bdd_web.telephone t on entreprise.id_telephone = t.id
                left join bdd_web.adresse a on entreprise.id_adresse = a.id
                left join bdd_web.ville v on a.id_ville = v.id
                left join bdd_web.pays p on v.id_pays = p.id
                where entreprise.id=?";
        $result=$this->ExecuteQueryByID($query,$id_entreprise);
        $data=$result->fetch_assoc();
        $entreprise= new Entreprise(
            (int)$data['id'],
            $data['nom'],
            $data['adresse'],
            $data['ville'],
            $data['code_postal'],
            $data['pays'],
            $data['descritption'],
            $data['numero'],
            $data['file'],
            $data['email'],
            $this->getMoyNote((float)$data['id']),
            $this->getNbPosts((int)$data['id'])
        );
        $result->close();
        return $entreprise;
    }

    public function getMoyNote($id_entreprise)
    {
        $query="select AVG(evaluation_entreprise.note) as note from evaluation_entreprise where id_entreprise=?;";
        $result = $this->ExecuteQueryByID($query,$id_entreprise);
        $data = $result->fetch_assoc();
        $result->close();
        return (float)$data['note'];
    }

    public function getNbPosts($id_entreprise)
    {
        $query="select count(id) as nb from posts where id_entreprise=?";
        $result = $this->ExecuteQueryByID($query,$id_entreprise);
        $data = $result->fetch_assoc();
        $result->close();
        return (int)$data['nb'];
    }


}