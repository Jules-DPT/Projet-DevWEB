<?php

namespace App\php\Repositories;

use App\php\Contenants\Posts;
require_once 'Repository.php';


class Postsrepository extends Repository
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




    public function getPrimaryData()
    {
        $words=explode(" ",trim($this->recherche));
        $where = "";
        if (!empty($words) && $words[0] !== "") {
            $rec = [];
            foreach ($words as $word) {
                $rec[] = "CONCAT(titre, ' ', description, ' ', e.nom,' ',v.nom) LIKE '%".$word."%'";
            }
            $where = "WHERE " . implode(" AND ", $rec);
        }


        $query = ("select posts.id AS id,titre, CONCAT(SUBSTRING_INDEX(description,' ',30), '...') AS description_pointille,
                   remuneration,d.date as date_post,d2.date as date_debut,d3.date as date_fin,nb_de_postulations,nombre_wishlist,
                    e.nom as entreprise,v.nom as ville ,c.type as contrat
                    FROM bdd_web.posts
                      left JOIN bdd_web.date d ON d.id = posts.id_date_post
                      left join bdd_web.date d2 ON d2.id = posts.id_date_debut
                      left join bdd_web.date d3 ON d3.id = posts.id_date_fin
                      left JOIN bdd_web.entreprise e ON posts.id_entreprise = e.id
                      left JOIN bdd_web.adresse a ON posts.id_adresse = a.id
                      left JOIN bdd_web.ville v ON a.id_ville = v.id
                      left JOIN bdd_web.contrat c on posts.id_contrat = c.id
                     $where
                    order by date_post LIMIT ? OFFSET ? ");

        $row =$this->SQL->prepare($query);
        $row->bind_param("ii",$this->limit,$this->offset);
        $row->execute();
        $result = $row->get_result();
        $posts=[];
        while ( $data = $result->fetch_assoc()) {
            $posts[] =
                new Posts(
                    (int)$data['id'],
                    htmlspecialchars($data['titre'], ENT_QUOTES, 'UTF-8'),
                    htmlspecialchars($data['description_pointille'], ENT_QUOTES, 'UTF-8'),
                    htmlspecialchars($data['date_post'], ENT_QUOTES, 'UTF-8'),
                    "",
                    "",
                    "",
                    htmlspecialchars($data['ville'], ENT_QUOTES, 'UTF-8'),
                    (int)$data['nb_de_postulations'],
                    htmlspecialchars($data['entreprise'], ENT_QUOTES, 'UTF-8'),
                    htmlspecialchars($data['remuneration'], ENT_QUOTES, 'UTF-8'),
                    htmlspecialchars($data['date_debut'], ENT_QUOTES, 'UTF-8'),
                    htmlspecialchars($data['date_fin'], ENT_QUOTES, 'UTF-8'),
                    (int)$data['nombre_wishlist'],
                    htmlspecialchars($data['contrat'], ENT_QUOTES, 'UTF-8'),
                    ""
                )
            ;
        }
        $row->close();
        return $posts;

    }

    public function getSecondaryData()
    {
        $query = ("select count(posts.id) as nb
                    FROM bdd_web.posts
                      left JOIN bdd_web.date d ON d.id = posts.id_date_post
                      left JOIN bdd_web.entreprise e ON posts.id_entreprise = e.id
                      left JOIN bdd_web.adresse a ON posts.id_adresse = a.id
                      left JOIN bdd_web.ville v ON a.id_ville = v.id
                      left JOIN bdd_web.contrat c on posts.id_contrat = c.id
                    where (titre like ?) or (description like ?) or (e.nom like ?) or (v.nom like ?) or (c.type like ?)
                    order by d.date ");
        $row =$this->SQL->prepare($query);
        $row->bind_param("sssss",$this->recherche,$this->recherche,$this->recherche,$this->recherche,$this->recherche);
        $row->execute();
        $result = $row->get_result();
        $data = $result->fetch_assoc();
        return (int)$data['nb'];
    }

}