<?php

namespace App\php\Controllers;

use App\php\Controllers\Controller;
use App\php\Services\Statservice;

class Indexcontroller extends Controller
{

    public function __construct($id_user_,$role_,$loggedin_,$template_)
    {
        $this->id_user=$id_user_;
        $this->role=$role_;
        $this->loggedin=$loggedin_;
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
        $recentposts=$this->service->getPostsNew();
        $olderposts=$this->service->getPostsOld();
        header('Content-Type: text/html; charset=UTF-8');
        $path="/ ";
        echo $this->template->render('welcomepage.html.twig',["role"=>$this->role,"path"=>$path,"trendingPosts"=>$trendingPosts,"MostW"=>$MostW,"NbPosts"=>$NbPosts,"NbMoyPosts"=>$NbMoyPosts,"limit"=>$limit,"contenant1"=>$recentposts,"contenant2"=>$olderposts]);
    }
}