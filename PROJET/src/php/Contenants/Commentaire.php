<?php

namespace App\php\Contenants;

class Commentaire
{
    private $id;
    private $note;
    private $commentaire;
    private $nom;
    private $prenom;
    private $date;
    private $id_cible;


    public function __construct($id_,$note_,$commentaire_,$nom_,$prenom_,$date_,$id_cible_)
    {
        $this->id = $id_;
        $this->note = $note_;
        $this->commentaire = $commentaire_;
        $this->nom = $nom_;
        $this->prenom = $prenom_;
        $this->date = $date_;
        $this->id_cible = $id_cible_;
    }

    #-----------------------------------------------getters----------------------------------------------------

    public function getId()
    {
        return $this->id;
    }

    public function getNote()
    {
        return $this->note;
    }

    public function getCommentaire()
    {
        return $this->commentaire;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function getPrenom()
    {
        return $this->prenom;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getIdCible()
    {
        return $this->id_cible;
    }

    #-----------------------------------------------setters----------------------------------------------------

    public function setId($id_)
    {
        $this->id = $id_;
    }

    public function setNote($note_)
    {
        $this->note = $note_;
    }

    public function setCommentaire($commentaire_)
    {
        $this->commentaire = $commentaire_;
    }

    public function setNom($nom_)
    {
        $this->nom = $nom_;
    }

    public function setPrenom($prenom_)
    {
        $this->prenom = $prenom_;
    }

    public function setDate($date_)
    {
        $this->date = $date_;
    }

    public function setIdCible($id_cible_)
    {
        $this->id_cible = $id_cible_;
    }
}