<?php
namespace App\php;


use mysql_xdevapi\Exception;
use mysqli;
class main  {
    private $mysqli;
    public function __construct(){
        $env=parse_ini_file("../.env");
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        try {
            $this->mysqli = new mysqli($env["DB_HOST"], $env["DB_USER"], $env["DB_MDP"], $env["DB_BDD"], $env["DB_PORT"]);
            $this->mysqli->set_charset("utf8mb4");
        } catch(Exception $e) {
            error_log($e->getMessage());
            exit('Error connecting to database');
        }
    }
    public function getSQL(){
        return $this->mysqli;

    }
}





