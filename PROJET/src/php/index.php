<?php
/**
 * This is the router, the main entry point of the application.
 * It handles the routing and dispatches requests to the appropriate controller methods.
 */

require "../../vendor/autoload.php";


/**
error_reporting(E_ALL);
ini_set('display_errors', 1);
 **/

use php\Controllers\Recherchecontroller;


$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader, [
    'debug' => true
]);


$postscontroller = new Recherchecontroller(3);//posts

$postscontroller->getPrimaryData();