<?php

namespace App\php\Services;

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

    private $post;

    private $file;
    private $uploaddir;

    public function __construct($id_post_,$id_utilisateur_,$file_,$uploaddir_)
    {
        $this->id_post = (int)$id_post_;
        $this->id_utilisateur = (int)$id_utilisateur_;
        $this->file = $file_;
        $this->uploaddir = $uploaddir_;
        $this->repository = new Postulationrepository();
        $this->Fileservice = new Fileservice();
        $this->Postsrepository = new Postsrepository();
        $this->post =$this->Postsrepository->getDataByID($id_post_);
    }

    public function getPageData()
    {
        return $this->Postsrepository->getDataByID($this->id_post);
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
            $this->repository->insertData($this->post);
            return true;
        }
        return false;
    }

}