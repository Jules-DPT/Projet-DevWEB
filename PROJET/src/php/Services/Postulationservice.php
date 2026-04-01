<?php

namespace App\php\Services;

use App\php\Contenants\Postulation;
use App\php\Repositories\Filerepository;
use App\php\Repositories\Postsrepository;
use App\php\Repositories\Postulationrepository;
use App\php\Services\Service;

class Postulationservice extends Service
{

    private $id_post;
    private $id_utilisateur;
    private $Fileservice;
    private $Postsrepository;
    private $LM;
    private $file;
    private $uploaddir;
    public function __construct()
    {
        $this->repository = new Postulationrepository();
        $num = func_num_args();
        switch ($num) {
            case 1: $this->__construct1(func_get_arg(0)); break;
            case 2: $this->__construct2(func_get_arg(0),func_get_arg(1)); break;
            case 4: $this->__construct3(func_get_arg(0), func_get_arg(1),func_get_arg(2),func_get_arg(3)); break;
        }
    }

    private function __construct1($id_utilisateur_):void
    {
        $this->id_utilisateur = (int)$id_utilisateur_;
    }

    private function __construct2($id_utilisateur_,$id_cible_):void
    {
        $this->id_utilisateur = (int)$id_utilisateur_;
        $this->id_post = $id_cible_;
    }

    private function __construct3($id_post_,$id_utilisateur_,$file_,$uploaddir_,$LM):void
    {
        $this->id_post = (int)$id_post_;
        $this->id_utilisateur = (int)$id_utilisateur_;
        $this->file = trim(htmlspecialchars($file_));
        $this->uploaddir = $uploaddir_;
        $this->Fileservice = new Fileservice();
        $this->Postsrepository = new Postsrepository();
        $this->LM = trim((string)$LM);
    }

    public function getPageData()
    {
        if ($this->insertData())
        {
            return " Postulation réussie!!! ";
        }
        return " echec de la Postulation :(";
    }

    private function UploadFilePDF()
    {
        if ($_FILES[$this->file]['error'] !== UPLOAD_ERR_OK) {
            return ['success' => false, 'message' => 'erreur de téléchargement serveur'];
        }

        $tailleMax = 2 * 1024 * 1024; // 2 Mo
        if ($_FILES[$this->file]["size"] > $tailleMax) {
            return ['success' => false, 'message' => "Fichier trop volumineux"];
        }

        if ($this->Fileservice->getMimeType($_FILES[$this->file]['tmp_name']) == 'application/pdf') {
            $uploadfile = $this->uploaddir . basename($_FILES[$this->file]['name']);

            if (!move_uploaded_file($_FILES[$this->file] ['tmp_name'], $uploadfile)) {
                return ['success' => false, 'message' => 'erreur de chemin serveur'];
            }
            return ['success' => true, 'message' => ' est un PDF et est accepté'];
        }
        else {
            return ['success' => false, 'message' => ' pas un fichier PDF '];
        }
    }
    public function insertData(){
        if ($this->UploadFilePDF()['success']===true) {
            $Filerepository = new Filerepository();
            if(!$Filerepository->checkFile($this->file))
            {
                $Filerepository->InsertData($this->file);
            }
            $idFile=$Filerepository->getIDByData($this->file);
            $postulation = new Postulation(
                "",
                $this->id_utilisateur,
                $this->id_post,
                $idFile,
                $this->LM
            );

            return $this->repository->insertData($postulation);
        }
        return false;
    }

    public function getCheckPosts($array)
    {
        $check=[];
        foreach ($array as $post) {
            if ($this->repository->checkPostulation($post->getId(),$this->id_utilisateur))
            {
                $check[]=true;
            }
            $check[]=false;
        }
        return $check;
    }

    public function checkPostulation()
    {
        return $this->repository->checkPostulation($this->id_post,$this->id_utilisateur);
    }

}