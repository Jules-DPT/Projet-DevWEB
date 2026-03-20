<?php

namespace App\php\Repositories;


use App\php\main;


abstract class Repository
{
protected $SQL;

public function autoSQL(){
    $m=new main();
    $this->SQL=$m->getSQL();;
}

public function setSQL($SQL_){
    $this->SQL = $SQL_;

}
abstract protected function getPrimaryData();



protected function getCountData($query_)
{
    $row =$this->SQL->prepare($query_);
    $row->execute();
    return $row->get_result();
}

protected function getDataByID($query_,$id_)
{
    $row =$this->SQL->prepare($query_);
    $row->bind_param("i",$id_);
    $row->execute();
    return $row->get_result();
}
}