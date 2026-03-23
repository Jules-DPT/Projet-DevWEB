<?php

namespace App\php\Repositories;

use App\php\Repositories\Repository;

class Filerepository extends Repository
{

    protected function DeleteDataByID($id_)
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

    protected function UpdateDataByID($id_, $contenant_)
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

    protected function InsertData($contenant_)
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

    protected function getDataByID($id_)
    {
        $query = "SELECT chemin FROM file WHERE id = ?";
        $result = $this->ExecuteQueryByID($query, $id_);
        return $result->fetch_assoc();
    }
}