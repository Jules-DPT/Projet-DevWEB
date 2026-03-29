<?php



namespace App\php\Controllers;


use App\php\Controllers\Controller;
use App\php\Services\Ficheservice;

class Fichecontroller extends Controller
{
    private $page;

    private $type;
    private $id_cible;

    private $Commentaire;

    public function __construct($id_cible_,$page,$type,$id_user_,$role_,$Commentaire_,$template_)
    {

        $this->template=$template_;
        $this->service=new Ficheservice($id_cible_,$role_,$id_user_,$page,4,$type);
        $this->id_cible=$this->service->getIdCible();
        $this->page = $this->service->getPage();
        $this->type = $this->service->getType();
        $this->id_user=$this->service->getIdUser();
        $this->role=$this->service->getRole();
        $this->Commentaire=trim((string)$Commentaire_);
        if (strlen($this->Commentaire)!=0)
        {
            $this->service->setCommentaire($this->Commentaire);
        }
    }
    public function getPageData()
    {
        $contenant=$this->service->getPageData();
        $totalpages=$this->service->getTotalPages();
        $path=$this->service->getPath("?id_cible=".$this->id_cible."&page=".$this->page);
        $commentaires=$this->service->getCommentaire();
        header('Content-Type: text/html; charset=UTF-8');
        echo $this->template->render('Fiche.html.twig',["path"=>$path,"totalPages"=>$totalpages,"contenant"=>$contenant,"type"=>$this->type,"id_cible"=>$this->id_cible,"role"=>$this->role,"commentaires"=>$commentaires]);

    }
}