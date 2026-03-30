<?php

namespace tests;

use App\php\Contenants\Compte;
use App\php\Contenants\Post;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertSame;

class CompteTest extends TestCase
{
    private $compte;

    public function setUp(): void
    {
        $this->compte = new Compte(
            1,
            "Dupont",
            "Jean",
            "password123",
            "ETUDIANT",
            "photo.jpg",
            10,
            "CPI A2",
            "jean.dupont@mail.com",
            "0600000000",
            100
        );
    }

    //-------------------GETTERS-------------------------

    public function testGetId()
    {
        $this->assertSame(1, $this->compte->getId());
    }

    public function testGetNom()
    {
        $this->assertSame("Dupont", $this->compte->getNom());
    }

    public function testGetPrenom()
    {
        $this->assertSame("Jean", $this->compte->getPrenom());
    }

    public function testGetPassword()
    {
        $this->assertSame("password123", $this->compte->getPassword());
    }

    public function testGetType()
    {
        $this->assertSame("ETUDIANT", $this->compte->getType());
    }

    public function testGetFile()
    {
        $this->assertSame("photo.jpg", $this->compte->getFile());
    }

    public function testGetIdPilote()
    {
        $this->assertSame(10, $this->compte->getIdPilote());
    }

    public function testGetPromo()
    {
        $this->assertSame("CPI A2", $this->compte->getPromo());
    }

    public function testGetEmail()
    {
        $this->assertSame("jean.dupont@mail.com", $this->compte->getEmail());
    }

    public function testGetTelephone()
    {
        $this->assertSame("0600000000", $this->compte->getTelephone());
    }

    public function testGetSnakeScore()
    {
        $this->assertSame(100, $this->compte->getSnakeScore());
    }

    //-------------------SETTERS-------------------------

    public function testSetId()
    {
        $this->compte->setId(2);
        $this->assertSame(2, $this->compte->getId());
    }

    public function testSetNom()
    {
        $this->compte->setNom("Martin");
        $this->assertSame("Martin", $this->compte->getNom());
    }

    public function testSetPrenom()
    {
        $this->compte->setPrenom("Paul");
        $this->assertSame("Paul", $this->compte->getPrenom());
    }

    public function testSetPassword()
    {
        $this->compte->setPassword("newpass");
        $this->assertSame("newpass", $this->compte->getPassword());
    }

    public function testSetType()
    {
        $this->compte->setType("ADMIN");
        $this->assertSame("ADMIN", $this->compte->getType());
    }

    public function testSetFile()
    {
        $this->compte->setFile("newphoto.png");
        $this->assertSame("newphoto.png", $this->compte->getFile());
    }

    public function testSetIdPilote()
    {
        $this->compte->setIdPilote(1);
        $this->assertSame(1, $this->compte->getIdPilote());
    }

    public function testSetPromo()
    {
        $this->compte->setPromo("ENSEIGNANT");
        $this->assertSame("ENSEIGNANT", $this->compte->getPromo());
    }

    public function testSetEmail()
    {
        $this->compte->setEmail("test@mail.com");
        $this->assertSame("test@mail.com", $this->compte->getEmail());
    }

    public function testSetTelephone()
    {
        $this->compte->setTelephone("0700000000");
        $this->assertSame("0700000000", $this->compte->getTelephone());
    }

    public function testSetSnakeScore()
    {
        $this->compte->setSnakeScore(200);
        $this->assertSame(200, $this->compte->getSnakeScore());
    }
}