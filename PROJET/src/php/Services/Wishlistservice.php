<?php

namespace App\php\Services;

use App\php\Repositories\Wishlistrepository;

class Wishlistservice
{
    private $id_user;
    private $role;

    private $id_post;

    private $Wishlistrepository;

    public function __construct($id_user, $role, $id_post)
    {
        $this->id_user = (int)$id_user;
        $this->role = (string)$role;
        $this->id_post = (int)$id_post;
        $this->Wishlistrepository=new Wishlistrepository($this->id_user,$this->id_post);
    }

    public function addToWishlist()
    {
        switch ($this->role)
        {
            case 'ETUDIANT':
                return $this->Wishlistrepository->addWish();
            default:
                return false;
        }

    }

    public function removeFromWishlist()
    {
        switch ($this->role)
        {
            case 'ETUDIANT':
                return $this->Wishlistrepository->DeleteWish();
            default:
                return false;
        }
    }
}