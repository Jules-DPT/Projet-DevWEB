<?php

class Postsservice
{
    private $Postsrep;
    public function __construct(Postsrepository $Postsrep_)
    {
        $this->Postsrep = $Postsrep_;
    }
    public function getPosts(){
        $result = $this->Postsrep->getPosts();
        while($result) {
            $posts[] = [
                "id" => (int)$result['id'],
                "titre" => htmlspecialchars($result['titre'], ENT_QUOTES, 'UTF-8'),
                "description" => htmlspecialchars($result['description_pointille'], ENT_QUOTES, 'UTF-8'),
                "remuneration" => htmlspecialchars($result['remuneration'], ENT_QUOTES, 'UTF-8'),
                "nb_postulants" => (int)$result['nb_de_postulations'],
                "nb_whishlist" => (int)$result['nombre_wishlist']
            ];
        }
        return $posts;
    }

    public function getPagination()
    {
        $totalPages=$this->Postsrep->getTotalPage();
        $page=$this->Postsrep->getPage();
        $listepagination = "";
        $listepagination.= "<br><br>".
            "<div class='pagination'>".
            "<a href='../../recherche.html?page=1'>"."<<"."</a>";
        if ($totalPages<3){
            $listepagination.="<a id='<' href='../../recherche.html?page=".($page-1>1 ?$page-1:1)."'>"."<"."</a>";
            for($i=1;$i<=$totalPages;$i++){
                if($page==$i){
                    $listepagination.="<a class='active' id=($i) href='../../recherche.html?page=".$i."'>".$i."</a>";
                }
                else{
                    $listepagination.="<a id=($i) href='../../recherche.html?page=".$i."'>".$i."</a>";
                }
            }
            $listepagination.="<a id='>' href='../../recherche.html?page=".($page+1<$totalPages ?$page+1:$totalPages)."'>".">"."</a>";
        }
        else
        {
            $listepagination.="<a href='../../recherche.php?page=".($page-2>2 ?$page-2:1)."'>"."<"."</a>";
            for($i=$page-2;$i<=$page+2;$i++){
                if($page==$i){
                    $listepagination.="<a class='active' id=($i) href='../../recherche.html?page=".$i."'>".$i."</a>";
                }
                else{
                    $listepagination.="<a id=($i) href='../../recherche.html?page=".$i."'>".$i."</a>";
                }
            }
            $listepagination.="<a href='../../recherche.php?page=".($i+2<=$totalPages-2 ?$i+2:$totalPages)."'>".">"."</a>";
        }
        $listepagination.=
            "<a href='../../recherche.html?page='".$totalPages."'>".">>"."</a>".
            "</div>";
        return $listepagination;
    }
}