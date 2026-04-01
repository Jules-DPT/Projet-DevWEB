<?php

namespace App\php\Repositories;

use App\php\Repositories\Repository;

class Filerepository extends Repository
{

//    private $id_file;
//
//    private $nom_file;
//
//    public function __construct($id_file_,$nom_file_)
//    {
//        $this->id_file = $id_file_;
//        $this->nom_file = $nom_file_;
//    }

    public function __construct()
    {
        $this->autoSQL();
    }
    public function DeleteDataByID($id_)
    {
        $query = "DELETE FROM file WHERE id = ?";
        $result = $this->ExecuteQueryByID($query, $id_);
        if ($result->affected_rows == 1) {
            $result->close();
            return true;
        }
        $result->close();
        return false;
    }

    public function UpdateDataByID($id_, $contenant_)
    {
        $query = "UPDATE file SET chemin=? WHERE id = ?";
        $row=$this->SQL->prepare($query);
        $row->bind_param('si', $contenant_, $id_);
        $row->execute();
        if ($row->affected_rows == 1) {
            $row->close();
            return true;
        }
        $row->close();
        return false;
    }

    public function InsertData($contenant_)
    {
        $query= "INSERT INTO file (chemin) VALUES(?)";
        $row =$this->SQL->prepare($query);
        $row->bind_param("s", $contenant_);
        $row->execute();
        if ($row->affected_rows == 1) {
            $row->close();
            return true;
        }
        $row->close();
        return false;
    }

    public function getDataByID($id_)
    {
        $query = "SELECT chemin FROM file WHERE id = ?";
        $result = $this->ExecuteQueryByID($query, $id_);
        return $result->fetch_assoc();
    }

    public function getIDByData($contenant_)
    {
        $query = "SELECT id FROM file WHERE chemin = ?";
        $row =$this->SQL->prepare($query);
        $row->bind_param("s", $contenant_);
        $row->execute();
        $result = $row->get_result();
        $data = $result->fetch_assoc();
        if ($data === null) {
            return false;
        }
        return (int)$data['id'];

    }

    public function checkFile($filename)
    {
        $query="SELECT chemin FROM file WHERE chemin=?";
        $row=$this->SQL->prepare($query);
        $row->bind_param('s',$filename);
        $row->execute();
        $result=$row->affected_rows;
        if($result==0){
            return false;
        }
        return true;
    }
}