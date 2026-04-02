<?php

namespace tests;

use App\php\Contenants\Commentaire;
use App\php\Repositories\Postsrepository;
use PHPUnit\Framework\TestCase;

class FichecontrollerTest extends TestCase
{
    private $Fichecontroller;

    // from Fichecontroller
    private $mockPostulationService;

    private $page;

    private $type;
    private $id_cible;

    private $Commentaire;
    private $note;


    // from Controller
    private $mockTemplate;

    private $mockService;

    private $id_user;

    private $role;

    private $loggedin;

    public function setUp():void
    {

        $this->Commentaire="salut";
        $this->note=4;
        $this->type=2;
        $this->id_cible=4;
        $this->page=1;

        $this->id_user=2;
        $this->role="PILOTE";
        $this->loggedin=true;

        $comment1= new Commentaire(
            1,
            3,
            "bof surcoté maintenant",
            "Gravier",
            "Max",
            3,
            "2026-9-12",
            4
        );
        $comment2= new Commentaire(
            2,
            5,
            "incroyable",
            "Argiev",
            "Xam",
            4,
            "2026-3-12",
            4
        );


        $this->mockTemplate = $this->createMock(stdClass::class);
        $this->mockTemplate->method('render')->willReturn('rendered');




        $this->mockService = $this->createMock(Ficheservice::class);
        $this->mockService->method('getIdCible')->willReturn(4);
        $this->mockService->method('getType')->willReturn(2);
        $this->mockService->method('getIdUser')->willReturn(45);
        $this->mockService->method('getRole')->willReturn('ADMIN');
        $this->mockService->method('getPageData')->willReturn(['data']);
        $this->mockService->method('getTotalPages')->willReturn(1);
        $this->mockService->method('getCommentaire')->willReturn([$comment1, $comment2]);
        $this->mockService->method('getPath(get)')->willReturn('/recherche/Fiche?id_cible=4&page=1&type=2');
        $this->mockService->method('getPath')->willReturn('/recherche/Fiche');
    }
}