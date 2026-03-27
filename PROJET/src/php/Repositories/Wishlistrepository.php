<?php

namespace App\php\Repositories;

use App\php\Repositories\Repository;

class Wishlistrepository extends Repository
{

    private $id_user;

    private $id_post;

    public function __construct($id_user_,$id_post_){
        $this->autoSQL();
        $this->id_user = $id_user_;
        $this->id_post = $id_post_;
    }
    public function DeleteDataByID($id_)
    {

        $query="DELETE FROM whishlist WHERE id_posts=?";
        $row=$this->SQL->prepare($query);
        $row->bind_param('i',$id_);
        $row->execute();
        $result=$row->get_result();
        if($result->num_rows>=1){
            return true;
        }
        return false;
    }

    public function UpdateDataByID($id_, $contenant_)
    {
        // TODO: Implement UpdateDataByID() method.
    }

    public function InsertData($contenant_)
    {
        foreach ($contenant_ as $contenant)
        {
            $query="Insert into whishlist (id_utilisateur, id_posts) VALUES (?,?)";
            $row=$this->SQL->prepare($query);
            $row->bind_param('ii',$contenant['id_user'],$contenant['id_post']);
            $row->execute();
            $result=$row->get_result();
        }

        if($result->num_rows==1){
            return true;
        }
        return false;
    }

    public function getDataByID($id_)
    {
        // TODO: Implement getDataByID() method.
    }

    public function DeleteWish()
    {
        $query="DELETE FROM whishlist WHERE id_posts=? and id_utilisateur=?";
        $row=$this->SQL->prepare($query);
        $row->bind_param('ii',$this->id_post,$this->id_user);
        $row->execute();
        $result=$row->get_result();
        if($result->num_rows==1){
            return true;
        }
        return false;
    }

    public function addWish()
    {
        $query="INSERT INTO whishlist (id_utilisateur, id_posts) VALUES (?,?)";
        $row=$this->SQL->prepare($query);
        $row->bind_param('ii',$this->id_user,$this->id_post);
        $row->execute();
        $result=$row->get_result();
        if($result->num_rows==1){
            return true;
        }
        return false;
    }
}