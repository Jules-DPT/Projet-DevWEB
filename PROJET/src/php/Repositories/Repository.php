<?php

namespace php\Repositories;
require '../main.php';
abstract class Repository
{
protected $SQL=$mysqli;

public function setSQL($SQL_){
    $this->SQL = $SQL_;
}
abstract protected function getPrimaryData();
}