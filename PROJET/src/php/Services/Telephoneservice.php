<?php

namespace App\php\Services;

use App\php\Repositories\Telephonerepository;
use App\php\Services\Service;

class Telephoneservice extends Service
{

    public function __construct()
    {
        $this->repository=new Telephonerepository();
    }
    public function addTelephone($Telephone)
    {
        $telephone=trim((string)$Telephone);
        return $this->repository->InsertData($telephone);
    }

    public function getIdByTelephone($Telephone)
    {
        return $this->repository->getIdByTelephone($Telephone);
    }
}