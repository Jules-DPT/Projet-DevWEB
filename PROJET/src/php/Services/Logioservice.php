<?php

namespace App\php\Services;

use App\php\Repositories\Comptesrepository;
use App\php\Services\Service;

class Logioservice extends Service
{

    private $id_user;
    private $role;
    public function __construct($id_user_, $role_){
        $this->id_user = (int)$id_user_;
        $this->role = $role_;
        $this->repository= new Comptesrepository();
    }
    protected function getPageData()
    {
        return ["user"=>$this->id_user, "role"=>$this->role];
    }

    public function RESET($new_pass,$confirm_pass)
    {
        $new_pass=trim($new_pass);
        $confirm_pass=trim($confirm_pass);
        if(empty($new_pass)){
            return "Please enter the new password.";
        } elseif(strlen($new_pass) < 8){
            return "Password must have atleast 8 characters.";
        }
        else{
            $specialcarac=false;
            $list=[",","?",".","!","$","&","@"];
            for($i = 0; $i < strlen($new_pass); $i++){
                if(in_array($new_pass[$i], $list)){
                    $specialcarac=true;
                }
            }
            if(!$specialcarac){
                return "Please enter a valid password with specials caracters such as : ".implode(", ", $list);
            }
        }
        if($new_pass!=$confirm_pass){
            return "your new Password and Confirm password do not match.";
        }
        $password=password_hash($new_pass, PASSWORD_ARGON2ID);
        if($this->repository->UpdatePassByID($this->id_user,$password)){
            return "Password has been updated.";
        }
        else{
            return "Failed to update password.";
        }
    }

    public function LogIn()
    {

    }

    public function LogOut(){
        // Initialize the session
        session_start();
        // Unset all the session variables
        $_SESSION = array();
        session_unset();
        // Destroy the session.
        session_destroy();
        return true;
    }

}