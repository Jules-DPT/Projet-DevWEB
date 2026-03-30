<?php

namespace App\php\Repositories;

use App\php\Repositories\Repository;

class TypeUtilisateurrepository extends Repository
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
        // TODO: Implement InsertData() method.
    }

    public function getDataByID($id_)
    {
        $query = "SELECT type FROM type_utilisateur WHERE id = ?";
        $result=$this->ExecuteQueryByID($query, $id_);
        return (int)$result['type'];
    }

    public function getLastInsertId()
    {
        return $this->lastInsertId;
    }

    public  function getIdByRole($role_)
    {
        $query = "SELECT id FROM type_utilisateur WHERE type = ?";
        $row=$this->SQL->prepare($query);
        $row->bind_param('s', $role_);
        $row->execute();
        $result = $row->fetch_assoc();
        return (int)$result['id'];
    }
}