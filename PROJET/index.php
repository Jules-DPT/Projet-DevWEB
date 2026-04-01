<?php
/**
 * This is the router, the main entry point of the application.
 * It handles the routing and dispatches requests to the appropriate controller methods.
 */

require "vendor/autoload.php";

use App\php\Controllers\Fichecontroller;
use App\php\Controllers\Indexcontroller;
use App\php\Controllers\Postulationcontroller;
use App\php\Controllers\Recherchecontroller;
use App\php\Controllers\Errorcontroller;


error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

$theme="light-mode";
setcookie(
    'theme',
    $theme,
    [
        'path' => '/',
        'secure' => false,      // HTTPS non obligatoire
        'httponly' => false,    //  accessible en JS
        'samesite' => 'Lax' // ou Strict
    ]
);


session_set_cookie_params([
    'lifetime' => 0, // expire à la fermeture du navigateur
    'path' => '/',
    'secure' => true,     // HTTPS obligatoire
    'httponly' => true,   // pas accessible JS
    'samesite' => 'Strict'
]);
session_start(['id_user','role','loggedin']);

if ( !isset($_SESSION['loggedin'])) {
    $_SESSION['loggedin'] = false;
}
if (!isset($_SESSION['role'])) {
    $_SESSION['role']='NO';
}
if (!isset($_SESSION['id_user'])) {
    $_SESSION['id_user']=-1;
}

//$id_user = (int)$_SESSION['id_user'];
//$role = $_SESSION['role'];
$loggedin = $_SESSION['loggedin'];

$id_user=1;
$role = "ETUDIANT";

$loader = new \Twig\Loader\FilesystemLoader('src/Templates');
$twig = new \Twig\Environment($loader, [
    'debug' => true
]);

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($uri) {
    case '/':
        $Indexcontroller=new Indexcontroller($twig);
        $Indexcontroller->getPageData();
        break;

    case '/recherche':
        $Page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $recherche = isset($_GET['recherche']) ? (string)$_GET['recherche'] : '';
        $int =isset($_GET['type']) ? (int)$_GET['type'] : 3;
        $Recherchecontroller = new Recherchecontroller($int,$Page,$recherche,$twig,$id_user,$role);

        $Recherchecontroller->getPageData();

        break;

    case '/recherche/fiche':
        $type =(isset($_GET['type']) and ($role!="ETUDIANT" and $role!="NO")) ? (int)$_GET['type'] : 3;
        $id_cible=isset($_GET['id_cible'])? (int)$_GET['id_cible'] : -1;
        if($type==1){
            $Fichecontroller = new Fichecontroller($id_cible,$type,$id_user,$role,$twig);
        }
        else{
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            if($_SERVER['REQUEST_METHOD'] === 'POST')
            {
                $commentaire=isset($_POST['comment']) ? (string)$_POST['comment'] : '';
                $note=isset($_POST['note']) ? (float)$_POST['note'] : 0;
                if ($commentaire!="" and $note!=0)
                {
                    echo $commentaire;
                    echo $note;
                    $Fichecontroller = new Fichecontroller($id_cible,$page,$type,$id_user,$role,$commentaire,$note,$twig);
                    $Fichecontroller->setcommentaire();
                    $commentaire="";
                    $note=0;
                    header("Location: "  .'/recherche/fiche'."?type=$type&id_cible=$id_cible&page=$page");

                }

            }
            else
            {
                $Fichecontroller = new Fichecontroller($id_cible,$page,$type,$id_user,$role,$twig);
            }
            $commentaire="";
            $note=0;


        }
        $Fichecontroller->getPageData();
        break;

    case '/recherche/Fiche/Postuler':
        $id_cible=isset($_GET['id_cible'])? (int)$_GET['id_cible'] : -1;
        //$CV=isset($_POST['CV']) ? $_POST['CV'] : '';
        $Postulationcontroller = new Postulationcontroller($id_user,$role,$loggedin,'',$id_cible,"",$twig);
        $Postulationcontroller->getPageData();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $LM=isset($_POST['LM'])? (string)$_POST['LM'] : "";
            if ($LM!="")
            {
                $Postulationcontroller = new Postulationcontroller($id_user,$role,$loggedin,'CV',$id_cible,$LM,$twig);
                $Postulationcontroller->getPostulationData();
                header('Location: ' .'recherche/fiche?type=3&id_cible='.$id_cible."&page=1");
                $LM="";
            }

        }
        break;

        case '/connexion':
            echo "connexion";
            break;

        case '/mentions-legales':
            echo "mentions-legales";
            break;

        case '/dashboard':
            echo "dashboard";//je ne sais pas si nous en avons vraiment besoin ou si nous ferons via connexion ?
            break;

    default:
        $Errorcontroller =new Errorcontroller($twig,"404");
        $Errorcontroller->getPageData();
        break;
}

