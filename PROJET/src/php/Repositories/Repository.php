<?php

namespace php\Repositories;

abstract class Repository
{
protected $SQL;

public function setSQL($SQL_){
    $this->SQL = $SQL_;
}
abstract protected function getPrimaryData();
}