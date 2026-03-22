<?php

namespace App\php\Repositories;


use App\php\main;


abstract class Repository
{
protected $SQL;

protected function autoSQL(){
    $m=new main();
    $this->SQL=$m->getSQL();
}

public function setSQL($SQL_){
    $this->SQL = $SQL_;

}

abstract protected function DeleteDataByID($id_);//DELETE

abstract protected function UpdateDataByID($id_,$contenant_);//UPDATE

abstract protected function InsertDataByID($id_,$contenant_); //CREATE

abstract protected function getDataByID($id_); //READ

protected function ExecuteQueryByID($query_,$id_){
    $row =$this->SQL->prepare($query_);
    $row->bind_param("i",$id_);
    $row->execute();
    return $row->get_result();
}
}