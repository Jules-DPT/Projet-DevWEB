<?php

namespace App\php\Services;

use App\php\Services\Service;

class Paginationservice extends Service
{
    public function __construct(){


    }
    public function getPrimaryData()
    {

    }

    public function getPath($get_){
        $base=strtok($_SERVER['REQUEST_URI'], '?');
        $path=$base.$get_.'&page=';
        return $path;
    }
}