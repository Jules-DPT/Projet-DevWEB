<?php

namespace App\php\Services;

use App\php\Contenants\Compte;
use App\php\Contenants\Telephone;
use App\php\Repositories\Comptesrepository;
use App\php\Repositories\Emailrepository;
use App\php\Repositories\Entreprisesrepository;
use App\php\Repositories\Postsrepository;
use App\php\Repositories\Telephonerepository;
use App\php\Repositories\TypeUtilisateurrepository;
use App\php\Repositories\Wishlistrepository;
use App\php\Services\Service;

class Logioservice extends Service
{

    private $id_user;
    private $role;
    private $loggedin = false;
    private $Postsrepository;
    private $Wishlistsrepository;

    private $Entreprisesrepository;
    public function __construct($id_user_,$role_,$loggedin_){
        $this->id_user = (int)$id_user_;
        $this->role =trim((string)$role_);
        $this->loggedin = $loggedin_;
        $this->repository= new Comptesrepository($this->role,$this->id_user,12);
        $this->Postsrepository = new Postsrepository();
        $this->Wishlistsrepository= new Wishlistrepository($this->id_user);
        $this->Entreprisesrepository = new Entreprisesrepository();


    }
    public function getPageData()
    {
        if($this->role == 'ETUDIANT')
        {
           $contenant= $this->Wishlistsrepository->getNbWishes();
        }
        elseif ($this->role == 'ADMIN')
        {
            $contenant=[
                "NbUsers"=>$this->repository->getNbComptes(),
                "NbPosts"=>$this->Postsrepository->getNbPosts(),
                "NbEntreprises"=>$this->Entreprisesrepository->getNbEntreprises(),

            ];
        }
        elseif ($this->role == 'PILOTE')
        {
            $contenant=$this->repository->getStudentByPostulation();
        }
        else{
            $contenant=["user"=>$this->id_user, "role"=>$this->role, "loggedin"=>$this->loggedin];
        }
        return $contenant;
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
            if (password_verify($password, $passbyid)) {
                $this->setIdUser($id);
                $this->setRole($this->repository->getRoleByID($id));
                $_SESSION["loggedin"] = true;
                $_SESSION["id_user"] = $this->id_user;
                $_SESSION["role"] = $this->role;
                return "mot de passe correct";
            }
            else{
                return "mot de passe incorrect. ";
            }
        }

        else{
            return "une erreur est survenue.";
        }


    }

    public function LogOut(){

        $_SESSION["loggedin"] = false;
        $_SESSION["id_user"] = -1;
        $_SESSION["role"] = "NO";
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

    public function SignIn($Compte_,$confirm_pass_,$prefixe_,$emailPilote_)
    {
        $nom=trim($Compte_->getNom());
        $prenom=trim($Compte_->getPrenom());
        $email=trim($Compte_->getEmail());
        $role=trim($Compte_->getRole());
        $telephone=trim($Compte_->getTelephone());
        $prefixe=trim($prefixe_);
        $emailPilote=trim($emailPilote_);
        $promo=$Compte_->getPromo();
        $new_pass=trim($Compte_->getPassword());
        $confirm_pass=trim($confirm_pass_);

        $Telephonerepository=new Telephonerepository();
        $Emailrepository=new Emailrepository();
        $TypeUserrepository=new TypeUtilisateurrepository();

        if (empty($prefixe)  ) {
            return "prefixe obligatoire";
        }
        elseif (empty($emailPilote) and $role=="ETUDIANT") {
            return "email pilote obligatoire";
        }
        elseif (empty($emailPilote) ) {
            $idPilote=NULL;
        }
        else{
            $idPilote=$this->repository->getidByEmail($emailPilote);
        }

        if(empty($role))
        {
            return "role obligatoire";
        }
        else
        {
            $idtype=$TypeUserrepository->getDataByID($role);
        }


        $list = [",", "?", ".", "!", "$", "&", "@"];
        if(empty($new_pass) or empty($confirm_pass)){
            return "Veuillez entrer les mots de passes.";
        } elseif(strlen($new_pass) < 8){
            return "Le mot de passe doit avoir au moins 8 caractères.";
        }
        elseif ($new_pass!=$confirm_pass){
            return "Les mots de passe ne correspondent pas.";
        }
        elseif ($new_pass!=htmlspecialchars($new_pass)){
            return "Veuillez n'utiliser que des caractères spéciaux comme ".implode(", ", $list);
        }
        else {
            $specialcarac = false;
            for ($i = 0; $i < strlen($new_pass); $i++) {
                if (in_array($new_pass[$i], $list)) {
                    $specialcarac = true;
                }
            }
            if (!$specialcarac) {
                return "Veuillez entrer un mot de passe valide avec des caractères spéciaux tels que : " . implode(", ", $list);
            }

        }
        if(!$Emailrepository->checkEmail($email))
        {
            return "l'adresse email est déjà utilisé ";
        }
        elseif (!$Telephonerepository->checkTelephone($telephone))
        {
            $Telephonerepository->InsertData(new Telephone("",$telephone,$prefixe));
            $telID=$Telephonerepository->getLastInsertId();
        }
        else
        {
            $Emailrepository->InsertData($email);
            $emailID=$Emailrepository->getLastInsertId();
        }
        $hashpass=password_hash($new_pass, PASSWORD_ARGON2ID);
        $compte=new Compte(
            "",
            $nom,
            $prenom,
            $hashpass,
            $idtype,
            "",
            $idPilote,
            $promo,
            $email,
            $telID,
            0
        );
        if($this->repository->InsertData($compte)){
            return "Utilisateur ajouté";
        }
        else
        {
            return "Erreur lors de l'ajout de l'utilisateur";
        }

    }


    public function getIdUser()
    {
        return $this->id_user;
    }

    public function getRole()
    {
        return $this->role;
    }

}