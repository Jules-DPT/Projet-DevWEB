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
    protected function getWhere($recherche_)
    {
        $words=explode(" ",trim($recherche_));
        $where = "";
        if (!empty($words) && $words[0] !== "") {
            $rec = [];
            foreach ($words as $word) {
                $rec[] = "CONCAT(entreprise.nom, ' ', entreprise.descritption,' ',v.nom,' ',v.code_postal) LIKE '%".$word."%'";
            }
            $where = "WHERE " . implode(" AND ", $rec);
        }
        return $where;
    }}