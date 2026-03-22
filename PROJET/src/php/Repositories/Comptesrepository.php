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


    public function __construct($page_, $limit_, $recherche_)
    {
        $this->autoSQL();
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
                $rec[] = "CONCAT(utilisateur.id, ' ', utilisateur.nom, ' ', utilisateur.prenom,' ',t.type,' ',promo) LIKE '%".$word."%'";
            }
            $where = "WHERE " . implode(" AND ", $rec);
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
        if ($data==null){
            $data['nb']=1;
        }
        return (int)$data['nb'];
    }
}