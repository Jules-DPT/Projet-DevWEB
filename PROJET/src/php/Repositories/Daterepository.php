<?php

namespace App\php\Repositories;

use App\php\Repositories\Repository;
use PDO;

class Daterepository extends Repository
{
    private $LastInsertedId;
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
        $query="Insert into date (date) values (?)";
        $row=$this->SQL->prepare($query);
        $row->bind_param('s',$contenant_);
        $row->execute();
        $this->LastInsertedId=$row->insert_id;
        $result=$row->affected_rows;
        if($result==0)
        {
            return false;
        }
        return true;
    }

    public function getDataByID($id_)
    {
        // TODO: Implement getDataByID() method.
    }

    public function checkDate($date)
    {
        $query="select count(*) as nb from date where date=?";
        $row=$this->SQL->prepare($query);
        $row->bind_param('s',$date);
        $row->execute();
        $result=$row->get_result();
        $data=$result->fetch_assoc();
        if($data["nb"]>0)
        {
            return true;
        }
        return false;
    }

    public function getIdByDate($date)
    {
        $query="select id from date where date=?";
        $row=$this->SQL->prepare($query);
        $row->bind_param('s',$date);
        $row->execute();
        $result=$row->get_result();
        $data=$result->fetch_assoc();
        return (int)$data["id"];
    }

    public function getLastInsertedId()
    {
        return $this->LastInsertedId;
    }
}