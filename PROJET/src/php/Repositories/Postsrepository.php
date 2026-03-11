<?php

namespace php\Repositories;

use php\Contenants\Posts;

require_once("Posts.php");

class Postsrepository extends Repository
{
    private $limit = 12;
    private $page;
    private $offset;

    public function __construct($page_, $limit_)
    {
        $this->page = $page_;
        $this->limit = $limit_ >= 0 ? $limit_ : $this->limit;
        $this->offset = ($this->page - 1) * $this->limit;
    }


    public function getPage()
    {
        return $this->page;
    }

    public function getPrimaryData()
    {
        $query = ("select posts.id AS id,titre, CONCAT(SUBSTRING_INDEX(description,' ',30), '...') AS description_pointille,remuneration,date,
        nb_de_postulations,nombre_wishlist from posts join bdd_web.date d on d.id = posts.id_date_post order by date LIMIT $this->limit OFFSET $this->offset");//rep
        $row = $this->SQL->query($query);
        $result = $row->fetch_assoc();
        $posts=[];
        for ($i = 0; $i < count($result); $i++) {
            $posts[] = [
                new Posts(
                    (int)$result['id'],
                    htmlspecialchars($result['titre'], ENT_QUOTES, 'UTF-8'),
                    htmlspecialchars($result['description_pointille'], ENT_QUOTES, 'UTF-8'),
                    "",
                    "",
                    "",
                    "",
                    (int)$result['nb_de_postulations'],
                    "",
                    htmlspecialchars($result['remuneration'], ENT_QUOTES, 'UTF-8'),
                    "",
                    "",
                    (int)$result['nombre_wishlist'],
                    "",
                    ""
                )
            ];
        }

        return $posts;

    }

}