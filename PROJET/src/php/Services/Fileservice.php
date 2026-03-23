<?php

namespace App\php\Services;

use App\php\Repositories\Filerepository;
use App\php\Services\Service;

class Fileservice extends Service
{

    public function __construct()
    {
        $this->repository = new Filerepository();
    }
    protected function getPageData()
    {
        // TODO: Implement getPageData() method.
    }

    public function getMimeType($file) {
        if (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $file);
            finfo_close($finfo);
            return $mimeType ?: 'application/octet-stream';
        }
        return 'application/octet-stream';
    }



    public function UploadFilePNG($file, $uploaddir) {
        if ($_FILES[$file]['error'] !== UPLOAD_ERR_OK) {
                return ['success' => false, 'message' => 'erreur de téléchargement serveur'];
            }

        $tailleMax =  1024 * 1024; // 1 Mo
        if ($_FILES[$file]["size"] > $tailleMax) {
                return ['success' => false, 'message' => "Fichier trop volumineux"];
            }

        if ($this->getMimeType($_FILES[$file]['tmp_name']) == 'image/png') {
                $uploadfile = $uploaddir . basename($_FILES[$file]['name']);

        if (!move_uploaded_file($_FILES[$file] ['tmp_name'], $uploadfile)) {
                    return ['success' => false, 'message' => 'erreur de chemin serveur '];
                }
                return ['success' => true, 'message' => ' est un png et est accepté'];
            }
        else{
                return ['success' => false, 'message' => 'pas une image png '];
            }
    }

    public function insertPNGBDD($file) {
        if ($this->repository->getIDByData($file)===false){
            $this->repository->insertData($file);
        }
    }

}