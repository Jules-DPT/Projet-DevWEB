<?php
namespace App\php\Contenants;

class Entreprises
{
    private $id;
    private $nom;
    private $adresse;
    private $description;
    private $telephone;
    private $file;

    private $email;

    //---------------------------- getters-------------------------------------------
    public function getId()
    {
        return $this->id;
    }
    public function getNom()
    {
        return $this->nom;
    }
    public function getAdresse()
    {
        return $this->adresse;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function getTelephone()
    {
        return $this->telephone;
    }
    public function getFile()
    {
        return $this->file;
    }
    public function getEmail()
    {
        return $this->email;
    }

    public function setId($id_)
    {
        $this->id = $id_;
    }
    public function setNom($nom_)
    {
        $this->nom = $nom_;
    }

    //------------------------------getters------------------------------------------

    public function setAdresse($adresse_)
    {
        return $this->adresse = $adresse_;
    }
    public function setDescription($description_)
    {
        return $this->description = $description_;
    }
    public function setTelephone($telephone_)
    {
        return $this->telephone = $telephone_;
    }
    public function setFile($file_)
    {
        $this->file = $file_;
    }
    public function setEmail($email_)
    {
        $this->email = $email_;
    }

}