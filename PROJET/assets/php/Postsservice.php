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
}