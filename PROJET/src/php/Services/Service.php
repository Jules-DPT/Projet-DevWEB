<?php

namespace App\php\Services;

abstract class Service
{
protected $repository;

abstract protected function getPrimaryData();
}