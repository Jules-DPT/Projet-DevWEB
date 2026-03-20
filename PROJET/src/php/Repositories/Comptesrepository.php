<?php

namespace App\php\Repositories;

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

    public function getPage()
    {
        return $this->page;
    }
    protected function getPrimaryData()
    {
        // TODO: Implement getPrimaryData() method.
    }
}