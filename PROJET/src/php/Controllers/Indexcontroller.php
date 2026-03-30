<?php

namespace App\php\Controllers;

use App\php\Controllers\Controller;
use App\php\Services\Statservice;

class Indexcontroller extends Controller
{

    public function __construct($template_)
    {
        $this->template=$template_;
        $this->service=new Statservice();
    }
    public function getPageData()
    {
        $trendingPosts=$this->service->getTrendingPosts();
        $MostW=$this->service->getMostWishPosts();
        $NbPosts=$this->service->getNbPosts();
        $NbMoyPosts=$this->service->getNbMoyCandidature();
        $limit=$this->service->getLimit();
        header('Content-Type: text/html; charset=UTF-8');
        $path="/ ";
        echo $this->template->render('welcomepage.html.twig',["path"=>$path,"trendingPosts"=>$trendingPosts,"MostW"=>$MostW,"NbPosts"=>$NbPosts,"NbMoyPosts"=>$NbMoyPosts,"limit"=>$limit]);
    }
}