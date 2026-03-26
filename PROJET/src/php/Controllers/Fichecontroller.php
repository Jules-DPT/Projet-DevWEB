<?php



namespace App\php\Controllers;


use App\php\Controllers\Controller;
use App\php\Services\Ficheservice;

class Fichecontroller extends Controller
{
    private $page;

    private $type;
    private $id_cible;

    public function __construct($id_cible_,$page,$type,$id_user_,$role_,$template_)
    {

        $this->template=$template_;
        $this->service=new Ficheservice($id_cible_,$role_,$id_user_,$page,4,$type);
        $this->id_cible=$this->service->getIdCible();
        $this->page = $this->service->getPage();
        $this->type = $this->service->getType();
        $this->id_user=$this->service->getIdUser();
        $this->role=$this->service->getRole();
    }
    public function getPageData()
    {
        $contenant=$this->service->getPageData();
        $nb=count($contenant);
        $totalpages=$this->service->getTotalPages();

        $path=$this->service->getPath("?id_cible=".$this->id_cible."&page=".$this->page);
        header('Content-Type: text/html; charset=UTF-8');
        if ($nb==0)
        {
            echo $this->template->render('File');
        }

    }
}