<?php

namespace php\Controllers;

use php\Repositories\Postsrepository;
use php\Services\Postsservice;

ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

require 'main.php';
require 'Postsservice.php';
require 'Postsrepository.php';

class Postscontroller
{
    private $Page;
    private $Postsservice;
    private $Postsrep;

    public function __construct(Postsservice $Postsservice_, Postsrepository $Postsrep_)
    {
        $this->Page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $this->Postsservice = $Postsservice_;
        $this->Postsrep = $Postsrep_;
        $totalPages = $this->Postsrep->getTotalPage();
        if ($this->Page < 1 or $this->Page > $totalPages) {
            $this->Page = $totalPages;
        }
    }

    public function getPosts()
    {
        $posts = $this->Postsrep->getPosts();
        $listepagination = $this->Postsservice->getPagination();
        echo json_encode([ //controller
            "aff" => $posts,
            "pagination" => $listepagination,
            "total" => (int)$this->Postsrep->getTotalPage()
        ]);
    }
}

$postsrepository = new Postsrepository($mysqli, 1, 12);
$postsservice = new Postsservice($postsrepository);
$postscontroller = new Postscontroller($postsservice, $postsrepository);

$postscontroller->getPosts();