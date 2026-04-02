<?php

namespace tests;

use App\php\Contenants\Commentaire;
use App\php\Contenants\Entreprise;
use App\php\Controllers\Fichecontroller;
use App\php\Repositories\Postsrepository;
use App\php\Services\Postulationservice;
use PHPUnit\Framework\TestCase;
use App\php\Services\Ficheservice;


class FakeTemplate {
    public function render($template, $data) {
        return 'rendered';
    }
}
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

        $comment3= new Commentaire(
            6,
            2,
            "incroyable vraiment mouhahaahah",
            "Blorb",
            "Le destroyeur de monde",
            42,
            "2024-7-6",
            4
        );


        $this->mockTemplate = $this->createMock(FakeTemplate::class);
        $this->mockTemplate->method('render')->willReturn('rendered');


        $this->mockService = $this->createMock(Ficheservice::class);
        $this->mockService->method('getIdCible')->willReturn(4);
        $this->mockService->method('getType')->willReturn(2);
        $this->mockService->method('getIdUser')->willReturn(5);
        $this->mockService->method('getRole')->willReturn('ADMIN');

        $this->mockService->method('getTotalPages')->willReturn(1);
        $this->mockService->method('getCommentaire')->willReturn([$comment1, $comment2]);
        $this->mockService->method('setCommentaire')->willReturn(true);
        $this->mockService->method('getPath')->willReturn('/recherche/Fiche?id_cible=4&page=1&type=2');

        $entreprise= new Entreprise(
            4,
            'Thales',
            "4 rue jsp",
            "Laba",
            "66600",
            "France",
            "Entreprise scpécialisé dans la fabrication de drone baguette",
            "0700000666",
            "company-logo.png",
            "ThalesBoulangery@gmail.fr",
            4.2,
            42
        );

        $this->mockService->method('getPageData')->willReturn($entreprise);



        $this->mockPostulationService = $this->createMock(Postulationservice::class);
        $this->mockPostulationService->method('checkPostulation')->willReturn(true);

        $this->ficheController = $this->getMockBuilder(Fichecontroller::class)
            ->disableOriginalConstructor()
            ->onlyMethods([])
            ->getMock();

        $reflection = new \ReflectionClass(Fichecontroller::class);
        $serviceProp = $reflection->getProperty('service');
        $serviceProp->setAccessible(true);
        $serviceProp->setValue($this->ficheController, $this->mockService);

        $postulationProp = $reflection->getProperty('Postulationservice');
        $postulationProp->setAccessible(true);
        $postulationProp->setValue($this->ficheController, $this->mockPostulationService);

        $templateProp = $reflection->getProperty('template');
        $templateProp->setAccessible(true);
        $templateProp->setValue($this->ficheController, $this->mockTemplate);


    }

    public function testSetCommentaireReturnsFalseIfInvalid()
    {
        $reflection = new \ReflectionClass(Fichecontroller::class);
        $noteProp = $reflection->getProperty('note');
        $noteProp->setAccessible(true);
        $noteProp->setValue($this->ficheController, 6); // note invalide

        $this->assertFalse($this->ficheController->setcommentaire());

        $noteProp->setValue($this->ficheController, 0); // note invalide
        $this->assertFalse($this->ficheController->setcommentaire());

        $commentProp = $reflection->getProperty('Commentaire');
        $commentProp->setAccessible(true);
        $commentProp->setValue($this->ficheController, ''); // commentaire vide
        $noteProp->setValue($this->ficheController, 4);
        $this->assertFalse($this->ficheController->setcommentaire());
    }

    public function testSetCommentaireCallsService()
    {
        $mockService = $this->createMock(Ficheservice::class);
        $mockService->expects($this->once())
            ->method('setCommentaire')
            ->willReturn(true);

        $reflection = new \ReflectionClass(Fichecontroller::class);
        $serviceProp = $reflection->getProperty('service');
        $serviceProp->setAccessible(true);
        $serviceProp->setValue($this->ficheController, $mockService);

        $this->assertTrue($this->ficheController->setcommentaire());
    }

    public function testCheckPostulationReturnsValue()
    {
        $this->assertTrue($this->ficheController->checkPostulation());
    }

}