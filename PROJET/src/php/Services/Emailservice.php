<?php

namespace App\php\Services;

use App\php\Repositories\Adresserepository;
use App\php\Repositories\Emailrepository;
use PharIo\Manifest\Email;

class Emailservice
{
   public function __construct()
   {
       $this->repository = new Emailrepository();
   }

   public function addEmail($Email)
   {
       $email=trim((string)$Email);
       if (empty($email))
           {
               return false;
           }
       elseif (!$this->repository->checkEmail($email))
       {
           $this->repository->InsertData($email);
       }
       return true;

   }

   public function getIdByEmail($Email)
   {
       $email=trim((string)$Email);
       return $this->repository->getIdByEmail($email);
   }
}