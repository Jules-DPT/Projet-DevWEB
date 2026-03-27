<?php

namespace App\php\Repositories;

use App\php\Contenants\Adresse;
use App\php\Repositories\Repository;

class Adresserepository extends Repository
{

    public function __construct()
    {
        $this->autoSQL();
    }

    protected function DeleteDataByID($id_)
    {
        // TODO: Implement DeleteDataByID() method.
    }

    protected function UpdateDataByID($id_, $contenant_)
    {
        // TODO: Implement UpdateDataByID() method.
    }

    protected function InsertData($contenant_)
    {

    }

    protected function getDataByID($id_)
    {
        $query="Select a.id, adresse, v.nom as ville, v.code_postal as code_postal ,p.nom as pays
                    from adresse a
                    left join bdd_web.ville v on v.id = a.id_ville
                    left join bdd_web.pays p on p.id = v.id_pays
                    where a.id=?";
        $result=$this->ExecuteQueryByID($query, $id_);
        $data=$result->fetch_assoc();
        $contenant=new Adresse(
            $data["id"],
            $data['adresse'],
            $data['ville'],
            $data['code_postal'],
            $data['pays']
        );
        return $contenant;
    }

    public function checkPays($pays)
    {
        $query="Select nom from pays where nom=?";
        $row=$this->SQL->prepare($query);
        $row->bind_param("s", $pays);
        $row->execute();
        $result=$row->fetch_assoc();
        if($result->affected_rows==1)
        {
            return true;
        }
        return false;
    }

    public function addPays($pays,$prefix_tel)
    {
        $query="Insert into pays(nom,prefix_tel) values(?,?)";
        $row=$this->SQL->prepare($query);
        $row->bind_param("ss",$pays,$prefix_tel);
        $row->execute();
        $result=$row->fetch_assoc();
        if($result->affected_rows==1)
        {
            return true;
        }
        return false;
    }

    public function checkVille($ville)
    {
        $query="Select nom from ville where nom=?";
        $row=$this->SQL->prepare($query);
        $row->bind_param("s", $ville);
        $row->execute();
        $result=$row->fetch_assoc();
        if($result->affected_rows==1)
        {
            return true;
        }
        return false;
    }

    public function addVille($ville,$pays,$code_postal)
    {
        $query="Insert into ville(nom,id_pays,code_postal) values(?,(select id from pays where nom=?),?)";
        $row=$this->SQL->prepare($query);
        $row->bind_param("sss",$ville,$pays,$code_postal);
        $row->execute();
        $result=$row->fetch_assoc();
        if($result->affected_rows==1)
        {
            return true;
        }
        return false;
    }

    public function checkAdresse($adresse)
    {
        $query="Select adresse from adresse where adresse=?";
        $row=$this->SQL->prepare($query);
        $row->bind_param("s", $adresse);
        $row->execute();
        $result=$row->fetch_assoc();
        if($result->affected_rows==1)
        {
            return true;
        }
        return false;
    }

    public function addAdresse($adresse,$ville)
    {
        $query="Insert into adresse(adresse,id_ville) values(?,(select id from ville where nom=?))";
        $row=$this->SQL->prepare($query);
        $row->bind_param("ss",$adresse,$ville);
        $row->execute();
        $result=$row->fetch_assoc();
        if($result->affected_rows==1)
        {
            return true;
        }
        return false;
    }

    public function Checkall($adresse,$ville,$pays)
    {
        if($this->checkPays($pays) and $this->checkVille($ville) and $this->checkAdresse($adresse))
        {
            return true;
        }
        return false;
    }
}