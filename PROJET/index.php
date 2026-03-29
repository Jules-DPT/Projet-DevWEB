<?php
/**
 * This is the router, the main entry point of the application.
 * It handles the routing and dispatches requests to the appropriate controller methods.
 */

require "vendor/autoload.php";

use App\php\Controllers\Fichecontroller;
use App\php\Controllers\Recherchecontroller;


error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

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

$id_user=3;
$role = "PILOTE";

$loader = new \Twig\Loader\FilesystemLoader('src/Templates');
$twig = new \Twig\Environment($loader, [
    'debug' => true
]);

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($uri) {
    case '/':
        // TODO : call the welcomePage method of the controller
        break;

    case '/recherche':
        $Page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $recherche = isset($_GET['recherche']) ? (string)$_GET['recherche'] : '';
        $int =isset($_GET['type']) ? (int)$_GET['type'] : 3;
        $recherchecontroller = new Recherchecontroller($int,$Page,$recherche,$twig,$id_user,$role);

        $recherchecontroller->getPageData();

        break;

    case '/recherche/fiche':
        $id_cible=isset($_GET['id_cible']) ? (int)$_GET['id_cible'] : -1;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $type =isset($_GET['type']) ? (int)$_GET['type'] : 3;
        $fichecontroller = new Fichecontroller($id_cible,$page,$type,$id_user,$role,$twig);
        $fichecontroller->getPageData();
        break;

    case '/recherche/Fiche/Postuler':
        echo "postuler";
        break;

    case '/connexion':
        echo "connexion";
        break;

    case '/dashboard':
        echo "dashboard";//je ne sais pas si nous en avons vraiment besoin ou si nous ferons via connexion ?
        break;

    default:
        // TODO : return a 404 error
        echo '404 Not Found';
        break;
}

