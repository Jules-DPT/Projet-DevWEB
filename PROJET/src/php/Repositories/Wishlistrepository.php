<?php

namespace App\php\Repositories;

use App\php\Repositories\Repository;

class Wishlistrepository extends Repository
{

    private $id_user;

    private $id_post;

    public function __construct(){
        $this->autoSQL();
        $num=func_num_args();
        switch($num){
            case 1:
                $this->__construct1(func_get_arg(0));
                break;
            case 2:
                $this->__construct2(func_get_arg(0),func_get_arg(1));
                break;
        }
    }

    private function __construct1($id_user_)
    {
        $this->id_user = $id_user_;

    }

    private function __construct2($id_user_,$id_post_)
    {
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
        $query="SELECT id_posts FROM whishlist WHERE id_utilisateur=?";
        $result=$this->ExecuteQueryByID($query,$id_);
        $id_posts=[];
        while($data=$result->fetch_assoc()){
            $id_posts[]=$data['id_posts'];
        }
        return $id_posts;

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

    public function getNbWishes()
    {
        $query="SELECT COUNT(id_posts) as nb FROM whishlist WHERE id_utilisateur=?";
        $result=$this->ExecuteQueryByID($query,$this->id_user);
        $data=$result->fetch_assoc();
        return (int)$data['nb'];
    }
}