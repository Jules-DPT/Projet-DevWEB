<?php

namespace App\php\Services;

use App\php\Contenants\Adresse;
use App\php\Contenants\Entreprise;
use App\php\Repositories\Entreprisesrepository;
use App\php\Services\Service;

class Entrepriseservice extends Service
{

    private $Adresseservice;
    private $Telephoneservice;

    private $Emailservice;

    private $Postulationservice;
    public function __construct()
    {
        $this->Adresseservice = new Adresseservice();
        $this->repository = new Entreprisesrepository();
        $this->Postsservice = new Postsservice();
        $this->Telephoneservice = new Telephoneservice();
        $this->Emailservice = new Emailservice();
    }
    public function addEntreprise($Entreprise)
    {
        $nom=trim((string)$Entreprise->getNom());
        $description=trim((string)$Entreprise->getDescription());
        $adresse=trim((string)$Entreprise->getAdresse());
        $ville=trim((string)$Entreprise->getVille());
        $pays=trim((string)$Entreprise->getPays());
        $code_postal=trim((string)$Entreprise->getCodePostal());
        $telephone=trim((string)$Entreprise->getTelephone());
        $email=trim((string)$Entreprise->getEmail());
        $Adresse=new Adresse(
            "",
            $adresse,
            $ville,
            $code_postal,
            $pays,
            "+xx"
        );
        if($this->Adresseservice->addAdresse($Adresse)){
            $idadresse=$this->Adresseservice->getIdByAdresse($Adresse);
        }
        elseif ($this->Emailservice->addEmail($email)){
            $idemail=$this->Emailservice->getIdByEmail($email);
        }
        elseif ($this->Telephoneservice->addTelephone($telephone)){
            $idtelephone=$this->Telephoneservice->getIdByTelephone($telephone);
        }



        $entreprise=new Entreprise(
            "",
            $nom,
            $idadresse,
            $idadresse,
            $idadresse,
            $idadresse,
            $description,
            $idtelephone,
            4,
            $idemail,
            "",
            ""


        );
        return $this->repository->InsertData($entreprise);
    }

    public function DeleteEntreprise($id_entreprise)
    {
        if($this->Postsservice)
        {
            return "Supprimez d'abord les posts.";
        }
        else
        {
            if($this->repository->DeleteDataByID($id_entreprise))
            {
                return "Entreprise supprimée.";
            }
            else
            {
                return "Echec de suppression.";
            }
        }
    }
}