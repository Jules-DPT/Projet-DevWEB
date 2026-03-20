<?php

namespace App\php\Repositories;

use App\php\Contenants\Posts;
require_once 'Repository.php';


class Postsrepository extends Rechercherepository
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
        $where = $this->getWhere($this->recherche);
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

        $result = $this->getSearchData($query,$this->limit,$this->offset);
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
        $result->close();
        return $posts;
    }

    public function getSecondaryData()
    {
        $where = $this->getWhere($this->recherche);
        $query = ("select count(posts.id) as nb
                    FROM bdd_web.posts
                      left JOIN bdd_web.date d ON d.id = posts.id_date_post
                      left JOIN bdd_web.entreprise e ON posts.id_entreprise = e.id
                      left JOIN bdd_web.adresse a ON posts.id_adresse = a.id
                      left JOIN bdd_web.ville v ON a.id_ville = v.id
                      left JOIN bdd_web.contrat c on posts.id_contrat = c.id
                    $where
                    order by d.date ");
        $result = $this->getCountData($query);
        $data = $result->fetch_assoc();
        if ($data==null){
            $data['nb']=1;
        }
        return (int)$data['nb'];
    }

    public function getpostbyid($id_post)
    {

    }

    public function getPostsbyEntreprise($id_entreprise)
    {

    }

}