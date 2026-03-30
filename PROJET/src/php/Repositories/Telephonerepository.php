<?php

namespace App\php\Repositories;

use App\php\Repositories\Repository;

class Telephonerepository extends Repository
{
    private $lastInsertId;
    private $Adresserepository;

    public function __construct()
    {
        $this->autoSQL();
        $this->Adresserepository=new Adresserepository();
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
        $numero=$contenant_->getNumero();
        $prefixe=$contenant_->getPrefixe();
        $id_prefixe=$this->Adresserepository->getIdByPrefixe($prefixe);
        $query="INSERT INTO telephone (numero, id_pays) VALUES (?,?)";
        $row=$this->SQL->prepare($query);
        $row->bind_param('ss',$numero,$id_prefixe);
        $row->execute();
        $this->lastInsertId=$row->insert_id;
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

    public function checkTelephone($telephone)
    {
        $query="SELECT * FROM telephone WHERE numero=?";
        $row=$this->SQL->prepare($query);
        $row->bind_param('s',$telephone);
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

    public function getIdByTelephone($Telephone)
    {
        $query="SELECT id FROM telephone WHERE numero=?";
        $row=$this->SQL->prepare($query);
        $row->bind_param('s',$Telephone);
        $row->execute();
        $result=$row->fetch_assoc();
        return (int)$result["id"];
    }
}