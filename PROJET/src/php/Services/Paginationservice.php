<?php

namespace App\php\Services;

use App\php\Services\Service;

class Paginationservice extends Service
{
    private $totalPages;
    public function __construct($totalpages_){
        $this->totalpages = $totalpages_;

    }
    public function getPrimaryData()
    {
        $page = $this->repository->getPage();
        $listepagination = "";
        $listepagination .= "<br><br>" .
            "<div class='pagination'>" .
            "<a href='../../../recherche.html?page=1'>" . "<<" . "</a>";
        if ($this->totalpages < 3) {
            $listepagination .= "<a id='<' href='../../recherche.html?page=" . ($page - 1 > 1 ? $page - 1 : 1) . "'>" . "<" . "</a>";
            for ($i = 1; $i <= $totalPages; $i++) {
                if ($page == $i) {
                    $listepagination .= "<a class='active' id=($i) href='../../../recherche.html?page=" . $i . "'>" . $i . "</a>";
                } else {
                    $listepagination .= "<a id=($i) href='../../../recherche.html?page=" . $i . "'>" . $i . "</a>";
                }
            }
            $listepagination .= "<a id='>' href='../../../recherche.html?page=" . ($page + 1 < $totalPages ? $page + 1 : $totalPages) . "'>" . ">" . "</a>";
        } else {
            $listepagination .= "<a href='../../../recherche.php?page=" . ($page - 2 > 2 ? $page - 2 : 1) . "'>" . "<" . "</a>";
            for ($i = $page - 2; $i <= $page + 2; $i++) {
                if ($page == $i) {
                    $listepagination .= "<a class='active' id=($i) href='../../../recherche.html?page=" . $i . "'>" . $i . "</a>";
                } else {
                    $listepagination .= "<a id=($i) href='../../../recherche.html?page=" . $i . "'>" . $i . "</a>";
                }
            }
            $listepagination .= "<a href='../../../recherche.php?page=" . ($i + 2 <= $totalPages - 2 ? $i + 2 : $totalPages) . "'>" . ">" . "</a>";
        }
        $listepagination .=
            "<a href='../../../recherche.html?page='" . $totalPages . "'>" . ">>" . "</a>" .
            "</div>";
        return $listepagination;
    }
}