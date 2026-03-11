<?php
namespace php\Repositories;

use php\Repositories\Repository;

class Paginationrepository extends Repository{

     private $total_pages;

    private function setTotalPage($total_page_)
    {
        $this->totalPages = $total_page_ < 1 ? 1 : $total_page_;
    }
    public function CalcTotalPage($from,$where)
    {
        //TODO: multiple query for every page we could have
        $query = "SELECT COUNT(*) as total FROM posts";
        $row = $this->SQL->query($query);
        $total = $row->fetch_assoc();
        $tot = ceil((int)$total['total'] / $this->limit);
        $this->setTotalPage($tot);
    }

    public function getPrimaryData()
    {
        return $this->total_page;
    }
 }