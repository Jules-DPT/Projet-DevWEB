<?php

namespace tests;

use App\php\Contenants\Post;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertSame;

class PostsTest extends TestCase
{
    private $post;

    public function  setUp(): void
    {
        $this->post= new Post(1,"Stage web","nous cherchons un developpeur web",
            "2025-06-01","jsp@mail.com","0789097624","4 rue de la Poste",
            "Paris","75000","France",12,"Technova","600€",
            "2025-09-01","2025-12-31",2,"STAGE","3 mois");

    }

    public function testgetId()
    {
       $this->assertSame(1, $this->post->getId());
    }

    public function testgetTitre()
    {
        $this->assertSame("Stage web", $this->post->getTitre());
    }

    public function testgetDescription()
    {
        $this->assertSame("nous cherchons un developpeur web", $this->post->getDescription());
    }

    public function testgetDateCreation()
    {
        $this->assertSame("2025-06-01", $this->post->getDateCreation());
    }

    public function testgetEmail()
    {
        $this->assertSame("jsp@mail.com", $this->post->getEmail());
    }

    public function testgetTelephone()
    {
        $this->assertSame("0789097624", $this->post->getTelephone());
    }

    public function testgetAdresse()
    {
        $this->assertSame("4 rue de la Poste",$this->post->getAdresse());
    }

    public function testgetVille(){
        $this->assertSame("Paris",$this->post->getVille());
    }
    public function testgetCodePostal(){
        $this->assertSame("75000",$this->post->getCodePostal());
    }
    public function testgetPays(){
        $this->assertSame("France",$this->post->getPays());
    }

    public function testgetNbPostulations()
    {
        $this->assertSame(12, $this->post->getNbPostulations());
    }

    public function testgetEntreprise()
    {
        $this->assertSame("Technova",$this->post->getEntreprise());
    }

    public function testgetRemuneration()
    {
        $this->assertSame("600€", $this->post->getRemuneration());
    }

    public function testgetDateDebut()
    {
        $this->assertSame("2025-09-01", $this->post->getDateDebut());
    }

    public function testgetDateFin()
    {
        $this->assertSame("2025-12-31", $this->post->getDateFin());
    }

    public function testgetNbWhishlist()
    {
        $this->assertSame(2, $this->post->getNbWhishlist());
    }

    public function testgetContrat()
    {
        $this->assertSame("STAGE",$this->post->getContrat());
    }

    public function testgetDuree()
    {
        $this->assertSame("3 mois", $this->post->getDuree());
    }

    //---------------set-methods---------------------------------------------------------------------------------------

    public function testsetId()
    {
        $this->post->setId(2);
        $this->assertSame(2, $this->post->getId());
    }

    public function testsetTitre()
    {
        $this->post->setTitre("Stage web2");
        $this->assertSame("Stage web2", $this->post->getTitre());
    }

    public function testsetDescription()
    {
        $this->post->setDescription("nous cherchons un dev web");
        $this->assertSame("nous cherchons un dev web", $this->post->getDescription());
    }

    public function testsetDateCreation()
    {
        $this->post->setDateCreation("2025-06-04");
        $this->assertSame("2025-06-04", $this->post->getDateCreation());
    }

    public function testsetEmail()
    {
        $this->post->setEmail("jsp2@gmail.com");
        $this->assertSame("jsp2@gmail.com", $this->post->getEmail());
    }

    public function testsetTelephone()
    {
        $this->post->setTelephone("0789097630");
        $this->assertSame("0789097630", $this->post->getTelephone());
    }

    public function testsetAdresse()
    {
        $this->post->setAdresse("3 rue du champs");
        $this->assertSame("3 rue du champs", $this->post->getAdresse());
    }

    public function testsetVille(){
        $this->post->setVille("Coulon");
        $this->assertSame("Coulon", $this->post->getVille());
    }
    public function testsetCodePostal(){
        $this->post->setCodePostal("90000");
        $this->assertSame("90000", $this->post->getCodePostal());
    }
    public function testsetPays(){
        $this->post->setPays("Japon");
        $this->assertSame('Japon', $this->post->getPays());
    }

    public function testsetNbPostulations()
    {
        $this->post->setNbPostulations(10);
        $this->assertSame(10, $this->post->getNbPostulations());
    }

    public function testsetEntreprise()
    {
        $this->post->setEntreprise("DRAVA");
        $this->assertSame("DRAVA", $this->post->getEntreprise());
    }

    public function testsetRemuneration()
    {
        $this->post->setRemuneration("1k€");
        $this->assertSame("1k€", $this->post->getRemuneration());
    }

    public function testsetDateDebut()
    {
        $this->post->setDateDebut("2025-06-21");
        $this->assertSame("2025-06-21", $this->post->getDateDebut());
    }

    public function testsetDateFin()
    {
        $this->post->setDateFin("2026-12-31");
        $this->assertSame("2026-12-31", $this->post->getDateFin());
    }

    public function testsetNbWhishlist()
    {
        $this->post->setNbWhishlist(4);
        $this->assertSame(4, $this->post->getNbWhishlist());
    }

    public function testsetContrat()
    {
        $this->post->setContrat("CDI");
        $this->assertSame("CDI", $this->post->getContrat());
    }

    public function testsetDuree()
    {
        $this->post->setDuree("1 mois");
        $this->assertSame("1 mois", $this->post->getDuree());
    }
}