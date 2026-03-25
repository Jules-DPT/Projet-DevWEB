<?php

namespace App\php\Contenants;

class Commentaire
{
    private $id;
    private $note;
    private $commentaire;
    private $utilisateur_nom;
    private $utilisateur_prenom;
    private $date;
    private $id_cible;


    public function __construct($id_,$note_,$commentaire_,$utilisateur_nom_,$utilisateur_prenom_,$date_,$id_cible_)
    {
        $this->id = $id_;
        $this->note = $note_;
        $this->commentaire = $commentaire_;
        $this->utilisateur_nom = $utilisateur_nom_;
        $this->utilisateur_prenom = $utilisateur_prenom_;
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

    public function getUtilisateurNom()
    {
        return $this->utilisateur_nom;
    }

    public function getUtilisateurPrenom()
    {
        return $this->utilisateur_prenom;
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

    public function setUtilisateurNom($utilisateur_nom_)
    {
        $this->utilisateur_nom = $utilisateur_nom_;
    }

    public function setUtilisateurPrenom($utilisateur_prenom_)
    {
        $this->utilisateur_prenom = $utilisateur_prenom_;
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