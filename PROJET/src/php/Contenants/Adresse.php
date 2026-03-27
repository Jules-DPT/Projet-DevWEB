<?php

namespace App\php\Contenants;

class Adresse
{
    private $id;
    private $adresse;
    private $ville;
    private $code_postal;
    private $pays;

    public function __construct($id_,$adresse_, $ville_, $code_postal_, $pays_)
    {
        $this->id = $id_;
        $this->adresse = $adresse_;
        $this->ville = $ville_;
        $this->code_postal = $code_postal_;
        $this->pays = $pays_;
    }

    #--------------------------------------------------getters--------------------------------------------------------
    public function getId()
    {
        return $this->id;
    }

    public function getAdresse()
    {
        return $this->adresse;
    }

    public function getVille()
    {
        return $this->ville;
    }

    public function getCodePostal()
    {
        return $this->code_postal;
    }

    public function getPays()
    {
        return $this->pays;
    }

    #-----------------------------------------------------setters--------------------------------------------------

    public function setId($id_)
    {
        $this->id = $id_;
    }

    public function setAdresse($adresse_)
    {
        $this->adresse = $adresse_;
    }

    public function setVille($ville_)
    {
        $this->ville = $ville_;
    }

    public function setCodePostal($code_postal_)
    {
        $this->code_postal = $code_postal_;
    }

    public function setPays($pays_)
    {
        $this->pays = $pays_;
    }

}