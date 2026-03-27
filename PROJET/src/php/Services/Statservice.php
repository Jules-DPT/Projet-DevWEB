<?php

namespace App\php\Services;

use App\php\Repositories\Comptesrepository;
use App\php\Repositories\Entreprisesrepository;
use App\php\Repositories\Postsrepository;


class Statservice
{

    private $limit;
    private $Compterepository;

    private $Entrepriserepository;

    private $Postrepository;


    public function __construct($limit)
    {
        $this->limit = $limit;
        $this->Compterepository=new Comptesrepository();
        $this->Entrepriserepository= new Entreprisesrepository();
        $this->Postrepository= new Postsrepository();
    }

    public function getTrendingPosts()
    {
        return $this->Postrepository->getTrendingPosts();
    }

    public function getNbposts()
    {
        return $this->Postrepository->getNbPosts();
    }

    public function getNbMoyCandidature()
    {
        return $this->Postrepository->getNbMoyCandidature();
    }

    public function getMostWishPosts()
    {
        return $this->Postrepository->getMostWishPosts();
    }

    public function getNbEntreprises()
    {
        return $this->Entrepriserepository->getNbEntreprises();
    }

    public function getNbUsers()
    {
        return $this->Compterepository->getNbComptes();
    }
}