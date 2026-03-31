<?php

namespace App\php\Repositories;

use App\php\Repositories\Repository;

class Emailrepository extends Repository
{
    private $lastInsertId;

    public function __construct()
    {
        $this->autoSQL();
    }
    public function DeleteDataByID($id_)
    {
        // TODO: Implement DeleteDataByID() method.
    }

    public function UpdateDataByID($id_, $contenant_)
    {
        // TODO: Implement UpdateDataByID() method.
    }

    public function InsertData($contenant_)
    {
        $query="INSERT INTO email (email) VALUES (?)";
        $row=$this->SQL->prepare($query);
        $row->bind_param('s',$contenant_);
        $row->execute();
        $result=$row->affected_rows;
        $this->lastInsertId=$row->insert_id;
        $row->close();
        if($result==0){
            return false;
        }
        return true;
    }

    public function getDataByID($id_)
    {
         $query="SELECT email FROM `email` WHERE `id`=?";
         $result=$this->ExecuteQueryByID($query,$id_);
         $data=$result->fetch_assoc();
         return $data["email"];
    }

    public function checkEmail($email)
    {
        $query="SELECT email FROM email WHERE LOWER(email)=LOWER(?)";
        $row=$this->SQL->prepare($query);
        $row->bind_param('s',$email);
        $row->execute();
        $result=$row->affected_rows;
        if($result==0){
            return false;
        }
        return true;
    }

    public function getLastInsertId()
    {
        return $this->lastInsertId;
    }

    public function getIdByEmail($email)
    {
        $query="SELECT id FROM `email` WHERE `email`=?";
        $row=$this->SQL->prepare($query);
        $row->bind_param('s',$email);
        $row->execute();
        $result=$row->fetch_assoc();
        return (int)$result["id"];
    }
}