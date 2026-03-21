<?php

namespace App\php\Contenants;

class Comptes
{
    private $id;

    private $nom;
    private $prenom;
    private $password;
    private $type;
    private $file;
    private $id_pilote;

    private $promo;
    private $email;

    private $telephone;
    private $snake_score;

    //-----------------------------Constructor----------------------------------

    public function __construct($id_,$nom_,$prenom_,$password_,$type_,$file_,$id_pilote_,$promo_,$email_,$telephone_,$snake_score_)
    {
        $this->id = $id_;
        $this->nom = $nom_;
        $this->prenom = $prenom_;
        $this->password = $password_;
        $this->type = $type_;
        $this->file = $file_;
        $this->id_pilote = $id_pilote_;
        $this->promo = $promo_;
        $this->email = $email_;
        $this->telephone = $telephone_;
        $this->snake_score = $snake_score_;
    }

    //-----------------------------------getters-------------------------------------

    public function getId()
    {
        return $this->id;
    }
    public function getNom()
    {
        return $this->nom;
    }

    public function getPrenom()
    {
        return $this->prenom;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function getType()
    {
        return $this->type;
    }
    public function getFile()
    {
        return $this->file;
    }
    public function getIdPilote()
    {
        return $this->id_pilote;
    }
    public function getPromo()
    {
        return $this->promo;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getTelephone()
    {
        return $this->telephone;
    }
    public function getSnakeScore()
    {
        return $this->snake_score;
    }
    //-----------------------------------setters-------------------------------------

    public function setId($id_)
    {
        $this->id = $id_;
    }
    public function setNom($nom_)
    {
        $this->nom = $nom_;
    }
    public function setPrenom($prenom_)
    {
        $this->prenom = $prenom_;
    }
    public function setPassword($password_)
    {
        $this->password = $password_;
    }
    public function setType($type_)
    {
        $this->type = $type_;
    }
    public function setFile($file_)
    {
        $this->file = $file_;
    }
    public function setIdPilote($id_pilote_)
    {
        $this->id_pilote = $id_pilote_;
    }
    public function setPromo($promo_)
    {
        $this->promo = $promo_;
    }
    public function setEmail($email_)
    {
        $this->email = $email_;
    }
    public function setTelephone($telephone_)
    {
        return $this->telephone = $telephone_;
    }
    public function setSnakeScore($snake_score_)
    {
        $this->snake_score = $snake_score_;
    }
}