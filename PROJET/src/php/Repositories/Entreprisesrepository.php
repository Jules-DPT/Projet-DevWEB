<?php

namespace App\php\Repositories;

use App\php\Contenants\Entreprises;
use App\php\Repositories\Repository;
require_once 'Repository.php';

class Entreprisesrepository extends Repository
{
    private $limit = 12;
    private $page;
    private $offset;

    private $recherche;
    public function __construct($page_, $limit_, $recherche_)
    {
        $this->autoSQL();
        $this->page = $page_;
        $this->limit = $limit_ >= 0 ? $limit_ : $this->limit;
        $this->offset = ($this->page - 1) * $this->limit;
        $this->recherche = $recherche_;
    }

    private function getWhere()
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
    public function getPrimaryData()
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
            $Entreprises[]= new Entreprises(
                (int)$data['id'],
                htmlspecialchars($data['nom']),
                htmlspecialchars($data['ville']),
                htmlspecialchars($data['description_pointille']),
                '',
                $data['file']==null ? "" : htmlspecialchars($data['file']),
                '',
                $this->getMoyNote((float)$data['id']),
                $this->getNbPosts((int)$data['id'])
            );
        }
        $result->close();
        return $Entreprises;
    }

    public function getSecondaryData()
    {

    }

    public function getAlldata()
    {

    }

    public function getpostbyid($id_post)
    {

    }

    public function getMoyNote($id_entreprise)
    {
        $query="select AVG(evaluation_entreprise.note) as note from evaluation_entreprise where id_entreprise=?;";
        $result = $this->getDataByID($query,$id_entreprise);
        $data = $result->fetch_assoc();
        return (float)$data['note'];
    }

    public function getNbPosts($id_entreprise)
    {
        $query="select count(id) as nb from posts where id_entreprise=?";
        $result = $this->getDataByID($query,$id_entreprise);
        $data = $result->fetch_assoc();
        return (int)$data['nb'];
    }
}