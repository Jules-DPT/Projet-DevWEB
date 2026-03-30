<?php

namespace tests;

use App\php\Contenants\Entreprise;
use App\php\Contenants\Post;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertSame;

class EntrepriseTest extends TestCase
{
    private $entreprise;

    public function setUp(): void
    {
        $this->entreprise = new Entreprise(
            1,
            "TechCorp",
            "10 rue de Paris",
            "Coulon",
            "79510",
            "France",
            "Entreprise spécialisée en développement",
            "0102030405",
            "logo.png",
            "contact@techcorp.com",
            4.5,
            20
        );
    }

    //-------------------GETTERS-------------------------

    public function testGetId()
    {
        $this->assertSame(1, $this->entreprise->getId());
    }

    public function testGetNom()
    {
        $this->assertSame("TechCorp", $this->entreprise->getNom());
    }

    public function testGetAdresse()
    {
        $this->assertSame("10 rue de Paris", $this->entreprise->getAdresse());
    }
    public function testGetVille()
    {
        $this->assertSame("Coulon", $this->entreprise->getVille());
    }
    public function testGetCodePostal()
    {
        $this->assertSame("79510", $this->entreprise->getCodePostal());
    }

    public function testGetPays()
    {
        $this->assertSame("France", $this->entreprise->getPays());
    }

    public function testGetDescription()
    {
        $this->assertSame("Entreprise spécialisée en développement", $this->entreprise->getDescription());
    }

    public function testGetTelephone()
    {
        $this->assertSame("0102030405", $this->entreprise->getTelephone());
    }

    public function testGetFile()
    {
        $this->assertSame("logo.png", $this->entreprise->getFile());
    }

    public function testGetEmail()
    {
        $this->assertSame("contact@techcorp.com", $this->entreprise->getEmail());
    }

    public function testGetNote()
    {
        $this->assertSame(4.5, $this->entreprise->getNote());
    }

    public function testGetNbPosts()
    {
        $this->assertSame(20, $this->entreprise->getNbPosts());
    }

    //-------------------SETTERS-------------------------

    public function testSetId()
    {
        $this->entreprise->setId(2);
        $this->assertSame(2, $this->entreprise->getId());
    }

    public function testSetNom()
    {
        $this->entreprise->setNom("NewCorp");
        $this->assertSame("NewCorp", $this->entreprise->getNom());
    }

    public function testSetAdresse()
    {
        $this->entreprise->setAdresse("20 avenue de Lyon");
        $this->assertSame("20 avenue de Lyon", $this->entreprise->getAdresse());
    }
    public function testSetVille()
    {
        $this->entreprise->setVille("Lyon");
        $this->assertSame("Lyon", $this->entreprise->getVille());
    }
    public function testSetCodePostal()
    {
        $this->entreprise->setCodePostal("69000");
        $this->assertSame("69000", $this->entreprise->getCodePostal());
    }
    public function testSetPays()
    {
        $this->entreprise->setPays("JAPON");
        $this->assertSame("JAPON", $this->entreprise->getPays());
    }

    public function testSetDescription()
    {
        $this->entreprise->setDescription("Nouvelle description");
        $this->assertSame("Nouvelle description", $this->entreprise->getDescription());
    }

    public function testSetTelephone()
    {
        $this->entreprise->setTelephone("0600000000");
        $this->assertSame("0600000000", $this->entreprise->getTelephone());
    }

    public function testSetFile()
    {
        $this->entreprise->setFile("newlogo.jpg");
        $this->assertSame("newlogo.jpg", $this->entreprise->getFile());
    }

    public function testSetEmail()
    {
        $this->entreprise->setEmail("new@mail.com");
        $this->assertSame("new@mail.com", $this->entreprise->getEmail());
    }

    public function testSetNote()
    {
        $this->entreprise->setNote(3.8);
        $this->assertSame(3.8, $this->entreprise->getNote());
    }

    public function testSetNbPosts()
    {
        $this->entreprise->setNbPosts(50);
        $this->assertSame(50, $this->entreprise->getNbPosts());
    }
}