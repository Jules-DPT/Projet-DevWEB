<?php

namespace php\Controllers;

use php\Repositories\Postsrepository;
use php\Services\Postsservice;
use php\Services\Recherchesservice;

ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');


require '../Services/Recherchesservice.php';


class Recherchecontroller extends Controller
{
    private $Page;


    public function __construct($int)
    {
        $this->Page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($this->Page < 1) {
            $this->Page = 1;
        }
        $this->service = new Recherchesservice($this->Page,$int);
    }

    public function getPrimaryData()
    {
        $contenant = $this->service->getPrimaryData();
        echo $this->template->rebder('Recherche.html.twig',$contenant);
    }
}


