<?php

namespace App\php\Contenants;

class Commentaire
{
    private $id;
    private $note;
    private $commentaire;
    private $id_utilisateur;

    private $id_cible;

    public function __construct($id_,$note_,$commentaire_,$id_utilisateur_,$id_cible_)
    {
        $this->id = $id_;
        $this->note = $note_;
        $this->commentaire = $commentaire_;
        $this->id_utilisateur = $id_utilisateur_;
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

    public function getIdUtilisateur()
    {
        return $this->id_utilisateur;
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

    public function setIdUtilisateur($id_utilisateur_)
    {
        $this->id_utilisateur = $id_utilisateur_;
    }

    public function setIdCible($id_cible_)
    {
        $this->id_cible = $id_cible_;
    }
}