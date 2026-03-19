<?php
/**
 * This is the router, the main entry point of the application.
 * It handles the routing and dispatches requests to the appropriate controller methods.
 */

require "vendor/autoload.php";
use App\php\Controllers\Recherchecontroller;


error_reporting(E_ALL);
ini_set('display_errors', 1);


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
        echo $int;
        $recherchecontroller = new Recherchecontroller($int,$Page,$recherche,$twig);

        $recherchecontroller->getPrimaryData();
        break;

    default:
        // TODO : return a 404 error
        echo '404 Not Found';
        break;
}

