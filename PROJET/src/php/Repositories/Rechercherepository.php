<?php

namespace App\php\Repositories;

use App\php\Repositories\Repository;

abstract class Rechercherepository extends Repository
{

    protected function getPageData()
    {}

    protected function DeleteDataByID($id_)
    {}
    protected function getDataByID($id_)
    {}

    protected function UpdateDataByID($id_, $contenant_)
    {}

    protected function InsertData($contenant_)
    {}

    abstract protected function getALLCount();

    abstract protected function getWhere();

    protected function getSearchData($query_,$limit_,$offset_)
    {
        $row =$this->SQL->prepare($query_);
        $row->bind_param("ii",$limit_,$offset_);
        $row->execute();
        return $row->get_result();
    }


}