<?php

namespace App\php\Services;

use App\php\Repositories\Comptesrepository;
use App\php\Services\Service;

class Logioservice extends Service
{

    private $id_user;
    private $role;
    private $loggedin = false;
    public function __construct($id_user_,$role_,$loggedin_){
        session_start();
        $this->id_user = $id_user_;
        $this->role = $role_;
        $this->loggedin = $loggedin_;
        $this->repository= new Comptesrepository();
    }
    protected function getPageData()
    {
        return ["user"=>$this->id_user, "role"=>$this->role, "loggedin"=>$this->loggedin];
    }

    public function RESET($new_pass,$confirm_pass)
    {
        $new_pass=trim($new_pass);
        $confirm_pass=trim($confirm_pass);
        if(empty($new_pass)){
            return "Veuillez entrer le nouveau mot de passe.";
        } elseif(strlen($new_pass) < 8){
            return "Le mot de passe doit avoir au moins 8 caractères.";
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
                return "Veuillez entrer un mot de passe valide avec des caractères spéciaux tels que : ".implode(", ", $list);
            }
        }
        if($new_pass!=$confirm_pass){
            return "votre nouveau mot de passe et le mot de passe de confirmation ne correspondent pas.";
        }
        $password=password_hash($new_pass, PASSWORD_ARGON2ID);
        if($this->repository->UpdatePassByID($this->id_user,$password)){
            return "Le mot de passe a été mis à jour.";
        }
        else{
            return "Échec de la mise à jour du mot de passe.";
        }
    }

    public function LogIn($email,$password)
    {
        $email = trim($email);
        $password = trim($password);
        if (empty($email) || empty($password)) {
            return "champs non remplis";
        }

        $id=$this->repository->getIdByEmail($email);
        if ($id==false) {
            return "email non valide";
        }

        $passbyid=$this->repository->getPassByID($id);
        if($passbyid!=null){
            $hashed_password =$passbyid;
            if (password_verify($password, $hashed_password)) {
                $this->setIdUser($id);
                $this->setRole($this->repository->getRoleByID($id));
                session_start();

                $_SESSION["loggedin"] = true;
                $_SESSION["id_user"] = $this->id_user;
                $_SESSION["role"] = $this->role;

                return "mot de passe correct";
            }
            else{
                return "mot de passe incorrect.";
            }
        }

        else{
            return "une erreur est survenue.";
        }


    }

    public function LogOut(){
        // Initialize the session
        session_start();
        // Unset all the session variables
        $_SESSION = array();
        session_unset();
        // Destroy the session.
        session_destroy();
        if(isset($_SESSION))
        {
            return false;
        }
        else
        {
            return true;
        }

    }
        private function setIdUser($id_user_)
    {
        $this->id_user = $id_user_;
    }

    private function setRole($role_)
    {
        $this->role = $role_;
    }

    public function SignIn($Compte_,$confirm_pass_)
    {
        $new_pass=trim($Compte_->getPassword());
        $confirm_pass=trim($confirm_pass_);
        if(empty($new_pass) or empty($confirm_pass)){
            return "Veuillez entrer les mots de passes.";
        } elseif(strlen($new_pass) < 8){
            return "Le mot de passe doit avoir au moins 8 caractères.";
        }
        elseif ($new_pass!=$confirm_pass){
            return "Les mots de passe ne correspondent pas.";
        }
        else {
            $specialcarac = false;
            $list = [",", "?", ".", "!", "$", "&", "@"];
            for ($i = 0; $i < strlen($new_pass); $i++) {
                if (in_array($new_pass[$i], $list)) {
                    $specialcarac = true;
                }
            }
            if (!$specialcarac) {
                return "Veuillez entrer un mot de passe valide avec des caractères spéciaux tels que : " . implode(", ", $list);
            }


        }
    }
}