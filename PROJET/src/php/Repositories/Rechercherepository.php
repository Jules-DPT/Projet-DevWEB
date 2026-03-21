<?php

namespace App\php\Repositories;

use App\php\Repositories\Repository;

abstract class Rechercherepository extends Repository
{

    protected function getPrimaryData()
    {}

    protected function getSearchData($query_,$limit_,$offset_)
    {
        $row =$this->SQL->prepare($query_);
        $row->bind_param("ii",$limit_,$offset_);
        $row->execute();
        return $row->get_result();
    }
    abstract protected function getWhere();

}