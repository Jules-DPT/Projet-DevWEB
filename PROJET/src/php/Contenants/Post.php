<?php

namespace App\php\Contenants;
class Post
{
    private $id;
    private $titre;
    private $description;
    private $date_creation;
    private $email;
    private $telephone;
    private $adresse;

    private $ville;
    private $code_postal;
    private $pays;
    private $nb_postulations;
    private $entreprise;
    private $remuneration;
    private $date_debut;
    private $date_fin;
    private $nb_whishlist;
    private $contrat;
    private $duree;

    private $competences;

    public function __construct($id_, $titre_, $description_, $date_creation_, $email_, $telephone_, $adresse_, $ville_,$code_postal_,$pays_, $nb_postulations_
        ,                       $entreprise_, $remuneration_, $date_debut_, $date_fin_, $nb_whishlist_, $contrat_, $duree_, $competences_)
    {
        $this->id = $id_;
        $this->titre = $titre_;
        $this->description = $description_;
        $this->date_creation = $date_creation_;
        $this->email = $email_;
        $this->telephone = $telephone_;
        $this->adresse = $adresse_;
        $this->ville = $ville_;
        $this->code_postal = $code_postal_;
        $this->pays = $pays_;
        $this->nb_postulations = $nb_postulations_;
        $this->entreprise = $entreprise_;
        $this->remuneration = $remuneration_;
        $this->date_debut = $date_debut_;
        $this->date_fin = $date_fin_;
        $this->nb_whishlist = $nb_whishlist_;
        $this->contrat = $contrat_;
        $this->duree = $duree_;
        $this->competences = $competences_;
    }

    //---------------get-methods---------------------------------------------------------------------------------------
    public function getId()
    {
        return $this->id;
    }

    public function getTitre()
    {
        return $this->titre;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getDateCreation()
    {
        return $this->date_creation;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getTelephone()
    {
        return $this->telephone;
    }

    public function getAdresse()
    {
        return $this->adresse;
    }

    public function getVille(){
        return $this->ville;
    }
    public function getCodePostal(){
        return $this->code_postal;
    }
    public function getPays(){
        return $this->pays;
    }

    public function getNbPostulations()
    {
        return $this->nb_postulations;
    }

    public function getEntreprise()
    {
        return $this->entreprise;
    }

    public function getRemuneration()
    {
        return $this->remuneration;
    }

    public function getDateDebut()
    {
        return $this->date_debut;
    }

    public function getDateFin()
    {
        return $this->date_fin;
    }

    public function getNbWhishlist()
    {
        return $this->nb_whishlist;
    }

    public function getContrat()
    {
        return $this->contrat;
    }

    public function getDuree()
    {
        return $this->duree;
    }


    public function getCompetences()
    {
        return $this->competences;
    }

    //---------------set-methods---------------------------------------------------------------------------------------

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setTitre($titre_)
    {
        $this->titre = $titre_;
    }

    public function setDescription($description_)
    {
        $this->description = $description_;
    }

    public function setDateCreation($date_creation_)
    {
        $this->date_creation = $date_creation_;
    }

    public function setEmail($email_)
    {
        $this->email = $email_;
    }

    public function setTelephone($telephone_)
    {
        $this->telephone = $telephone_;
    }

    public function setAdresse($adresse_)
    {
        $this->adresse = $adresse_;
    }

    public function setVille($ville_){
        $this->ville = $ville_;
    }
    public function setCodePostal($code_postal_){
        $this->code_postal = $code_postal_;
    }
    public function setPays($pays_){
        $this->pays = $pays_;
    }

    public function setNbPostulations($nb_postulations_)
    {
        $this->nb_postulations = $nb_postulations_;
    }

    public function setEntreprise($entreprise_)
    {
        $this->entreprise = $entreprise_;
    }

    public function setRemuneration($remuneration_)
    {
        $this->remuneration = $remuneration_;
    }

    public function setDateDebut($date_debut_)
    {
        $this->date_debut = $date_debut_;
    }

    public function setDateFin($date_fin_)
    {
        $this->date_fin = $date_fin_;
    }

    public function setNbWhishlist($nb_whishlist_)
    {
        $this->nb_whishlist = $nb_whishlist_;
    }

    public function setContrat($contrat_)
    {
        $this->contrat = $contrat_;
    }

    public function setDuree($duree_)
    {
        $this->duree = $duree_;
    }

    public function setCompetences($competences_)
    {
        $this->competences = $competences_;
    }

}