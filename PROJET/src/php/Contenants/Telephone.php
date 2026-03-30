<?php

namespace App\php\Contenants;

class Telephone
{
    private $id;
    private $numero;
    private $prefixe;

    public function __construct($id_,$numero_,$prefixe_)
    {
        $this->id=$id_;
        $this->numero=$numero_;
        $this->prefixe=$prefixe_;
    }

    public function getId()
    {
        return $this->id;
    }

    public  function getNumero()
    {
        return $this->numero;
    }

    public  function getPrefixe()
    {
        return $this->prefixe;
    }

    public function setId($id_)
    {
        $this->id=$id_;
    }

    public function setNumero($numero_)
    {
        $this->numero=$numero_;
    }

    public function setPrefixe($prefixe_)
    {
        $this->prefixe=$prefixe_;
    }
}