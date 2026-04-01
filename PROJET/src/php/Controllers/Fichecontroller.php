<?php



namespace App\php\Controllers;


use App\php\Contenants\Commentaire;
use App\php\Controllers\Controller;
use App\php\Services\Ficheservice;
use App\php\Services\Postulationservice;

class Fichecontroller extends Controller
{
    private $page;

    private $type;
    private $id_cible;

    private $Commentaire;
    private $note;

    private $Postulationservice;

    public function __construct()
    {
        $num=func_num_args();
        switch ($num) {
            case 5:
                $this->__construct1(func_get_arg(0),func_get_arg(1),func_get_arg(2),func_get_arg(3),func_get_arg(4));
                break;
            case 6:
                $this->__construct3(func_get_arg(0),func_get_arg(1),func_get_arg(2),func_get_arg(3),func_get_arg(4),func_get_arg(5));
                break;
            case 8:
                $this->__construct2(func_get_arg(0),func_get_arg(1),func_get_arg(2),func_get_arg(3),func_get_arg(4),func_get_arg(5),func_get_arg(6),func_get_arg(7));
                break;
        }

        $this->id_cible=$this->service->getIdCible();
        $this->type = $this->service->getType();
        $this->id_user=$this->service->getIdUser();
        $this->role=$this->service->getRole();

    }

    private function __construct1($id_cible_,$type_,$id_user_,$role_,$template_)
    {
        $this->template=$template_;
        $this->service=new Ficheservice($id_cible_,$role_,$id_user_,$type_);
    }

    private function __construct2($id_cible_,$page,$type,$id_user_,$role_,$Commentaire_,$note_,$template_)
    {
        $this->template=$template_;
        $this->service=new Ficheservice($id_cible_,$role_,$id_user_,$page,4,$type);
        $this->page = $this->service->getPage();
        $this->Commentaire=trim((string)$Commentaire_);
        $this->note=(float)$note_;
    }

    private function __construct3($id_cible_,$page,$type,$id_user_,$role_,$template_)
    {
        $this->template=$template_;
        $this->service=new Ficheservice($id_cible_,$role_,$id_user_,$page,4,$type);
        $this->page = $this->service->getPage();
        $this->Postulationservice=new Postulationservice($id_user_,$id_cible_);
    }
    public function getPageData()
    {
        $contenant=$this->service->getPageData();
        header('Content-Type: text/html; charset=UTF-8');
        if ($this->type==1)
        {
            $path=$this->service->getPath("?id_cible=".$this->id_cible."&type=".$this->type);
            echo $this->template->render('Fiche.html.twig',["path"=>$path,"contenant"=>$contenant,"type"=>$this->type,"id_cible"=>$this->id_cible,"role"=>$this->role]);
        }
        elseif ($this->type==2){
            $totalpages=$this->service->getTotalPages();
            $path=$this->service->getPath("?id_cible=".$this->id_cible."&type=".$this->type."&page=".$this->page);
            $commentaires=$this->service->getCommentaire();
            echo $this->template->render('Fiche.html.twig',["page"=>$this->page ,"path"=>$path,"totalPages"=>$totalpages,"contenant"=>$contenant,"type"=>$this->type,"id_cible"=>$this->id_cible,"role"=>$this->role,"commentaires"=>$commentaires]);
        }
        else
        {
            $totalpages=$this->service->getTotalPages();
            $path=$this->service->getPath("?id_cible=".$this->id_cible."&type=".$this->type."&page=".$this->page);
            $commentaires=$this->service->getCommentaire();
            $check=$this->Postulationservice->checkPostulation();
            echo $this->template->render('Fiche.html.twig',["page"=>$this->page ,"path"=>$path,"totalPages"=>$totalpages,"contenant"=>$contenant,"type"=>$this->type,"id_cible"=>$this->id_cible,"role"=>$this->role,"commentaires"=>$commentaires,"check"=>$check]);

        }




    }
    public function setcommentaire(){
        if (strlen($this->Commentaire)!=0 and $this->note>0 and $this->note<5)
        {
            $commentaire= new Commentaire(
                "",
                $this->note,
                $this->Commentaire,
                "",
                "",
                $this->id_user,
                "",
                $this->id_cible
            );

            return $this->service->setCommentaire($commentaire);
        }
        return false;
    }

    public function checkPostulation()
    {
        return $this->Postulationservice->checkPostulation();
    }
}