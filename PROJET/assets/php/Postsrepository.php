<?php

require_once("Posts.php");
class Postsrepository
{
    private $SQL;
    private $limit=12;
    private $total_page;
    private $page;
    private $offset;
    public function __construct($SQL_,$page_,$limit_)
    {
        $this->SQL = $SQL_;
        $this->page = $page_;
        $this->limit = $limit_>=0?$limit_:$this->limit;
        $this->offset = ($this->page - 1) * $this->limit;
    }

    private function setTotalPage($total_page_)
    {
        $this->totalPages=$total_page_<1?1:$total_page_;
    }
    public function CalcTotalPage()
    {
        $query ="SELECT COUNT(*) as total FROM posts";
        $row=$this->SQL->query($query);
        $total= $row->fetch_assoc();
        $tot=ceil((int)$total['total'] / $this->limit);
        $this->setTotalPage($tot);
    }
    public function getTotalPage()
    {
        return $this->total_page;
    }

    public function getPage()
    {
        return $this->page;
    }
    public function getPosts()
    {
        $query=("select posts.id AS id,titre, CONCAT(SUBSTRING_INDEX(description,' ',30), '...') AS description_pointille,remuneration,date,
        nb_de_postulations,nombre_wishlist from posts join bdd_web.date d on d.id = posts.id_date_post order by date LIMIT $this->limit OFFSET $this->offset");//rep
        $row=$this->SQL->query($query);
        $result=$row->fetch_assoc();
        for($i=0;$i<count($result);$i++) {
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
        if ($posts){
            return $posts;
        }
    }

}