<?php
namespace App\php;

use mysqli;
class main{
    private $mysqli;
    public function __construct(){
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        try {
            $this->mysqli = new mysqli("172.19.80.1", "adm", "SUPERADMIN", "bdd_web", 3306);
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




