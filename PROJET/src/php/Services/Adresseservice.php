<?php

namespace App\php\Services;

use App\php\Contenants\Adresse;
use App\php\Repositories\Adresserepository;
use App\php\Services\Service;

class Adresseservice extends Service
{

    public function __construct()
    {
        $this->repository = new AdresseRepository();
    }
    public function addAdresse(Adresse $Adresse)
    {
        $id=$Adresse->getId();
        $adresse=$Adresse->getAdresse();
        $ville=$Adresse->getVille();
        $code_postal=$Adresse->getCodePostal();
        $pays=$Adresse->getPays();
        $prefix_tel=$Adresse->getPrefixTel();

        foreach([$id,$adresse,$ville,$code_postal,$pays,$prefix_tel] as $data)
        {
            if (empty($data))
            {
                return "empty Adresse";
            }
        }

        if(!$this->repository->checkPays($pays))
        {
            $this->repository->addPays($pays,$prefix_tel);
        }
        elseif(!$this->repository->checkVille($ville))
        {
            $this->repository->addVille($ville,$pays,$code_postal);
        }
        elseif(!$this->repository->checkAdresse($adresse))
        {
            $this->repository->addAdresse($adresse,$ville);
        }
        return $this->repository->Checkall($adresse,$ville,$pays);
    }
}