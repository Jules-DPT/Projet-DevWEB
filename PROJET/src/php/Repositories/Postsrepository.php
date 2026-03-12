<?php

namespace php\Repositories;

use php\Contenants\Posts;

require_once("Posts.php");

class Postsrepository extends Repository
{
    private $limit = 12;
    private $page;
    private $offset;

    private $recherche;
    public function __construct($page_, $limit_, $recherche_)
    {
        $this->page = $page_;
        $this->limit = $limit_ >= 0 ? $limit_ : $this->limit;
        $this->offset = ($this->page - 1) * $this->limit;
        $this->recherche = $recherche_;
    }


    public function getPage()
    {
        return $this->page;
    }

    public function getPrimaryData()
    {

        $query = ("select posts.id AS id,titre, CONCAT(SUBSTRING_INDEX(description,' ',30), '...') AS description_pointille,
                   remuneration,d.date as date,nb_de_postulations,nombre_wishlist, e.nom as entreprise,v.nom as ville ,c.type as contrat
                    FROM bdd_web.posts
                     JOIN bdd_web.date d ON d.id = posts.id_date_post
                     JOIN bdd_web.entreprise e ON posts.id_entreprise = e.id
                     JOIN bdd_web.adresse a ON posts.id_adresse = a.id
                     JOIN bdd_web.ville v ON a.id_ville = v.id
                     JOIN bdd_web.contrat c on posts.id_contrat = c.id
                    where (titre like ?) or (description like ?) or (e.nom like ?) or (v.nom like ?) or (c.type like ?)
                    order by d.date LIMIT $this->limit OFFSET $this->offset");

        $row =$this->SQL->prepare($query);
        $row->bind("s",$this->recherche);
        $row->execute();
        $result = $row->fetch_assoc();
        $posts=[];
        for ($i = 0; $i < count($result); $i++) {
            $posts[] = [
                new Posts(
                    (int)$result['id'],
                    htmlspecialchars($result['titre'], ENT_QUOTES, 'UTF-8'),
                    htmlspecialchars($result['description_pointille'], ENT_QUOTES, 'UTF-8'),
                    htmlspecialchars($result['date'], ENT_QUOTES, 'UTF-8'),
                    "",
                    "",
                    "",
                    htmlspecialchars($result['ville'], ENT_QUOTES, 'UTF-8'),
                    (int)$result['nb_de_postulations'],
                    htmlspecialchars($result['entreprise'], ENT_QUOTES, 'UTF-8'),
                    htmlspecialchars($result['remuneration'], ENT_QUOTES, 'UTF-8'),
                    "",
                    "",
                    (int)$result['nombre_wishlist'],
                    htmlspecialchars($result['contrat'], ENT_QUOTES, 'UTF-8'),
                    ""
                )
            ];
        }
        $row->close();
        return $posts;

    }

}