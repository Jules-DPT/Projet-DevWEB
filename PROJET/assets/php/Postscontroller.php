<?php

class Postscontroller
{
    private $Page;
    private $Postsservice;
    private $Postsrep;
    public function __construct($Postsservice_, $Postsrep_)
    {
        $this->Page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $this->Postsservice = $Postsservice_;
        $this->Postsrep = $Postsrep_;
        $totalPages=$this->Postsrep->getTotalPages();
        if ($this->Page < 1 or $this->Page > $totalPages) {
            $this->Page = $totalPages;
        }
    }

    public function getPosts(){
        $posts = $this->Postsrep->getPosts();
        $listepagination=$this->Postsservice->getPagination();
        echo json_encode([ //controller
            "aff" => $posts,
            "pagination" => $listepagination,
            "total" => (int)$this->Postsrep->getTotalPages()
        ]);
    }
}