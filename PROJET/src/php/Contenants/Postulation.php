<?php

namespace App\php\Contenants;

class Postulation
{
    private $id;
    private $id_utilisateur;
    private $id_post;
    private $file;
    private $LM;


    public function __construct($id_,$id_utilisateur_,$id_post_,$file_,$LM_)
    {
        $this->id = $id_;
        $this->id_utilisateur = $id_utilisateur_;
        $this->id_post = $id_post_;
        $this->file = $file_;
        $this->LM = $LM_;
    }

    //---------------get-methods---------------------------------------------------------------------------------------

    public function getId()
    {
        return $this->id;
    }

    public function getIdUtilisateur()
    {
        return $this->id_utilisateur;
    }

    public function getIdPost()
    {
        return $this->id_post;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function getLM()
    {
        return $this->LM;
    }

    //---------------set-methods---------------------------------------------------------------------------------------

    public function setId($id_)
    {
        $this->id = $id_;
    }

    public function setIdUtilisateur($id_utilisateur_)
    {
        $this->id_utilisateur = $id_utilisateur_;
    }

    public function setIdPost($id_post_)
    {
        $this->id_post = $id_post_;
    }

    public function setFile($file_)
    {
        $this->file = $file_;
    }

    public function setLM($LM_)
    {
        $this->LM = $LM_;
    }
}