<?php
namespace App\php;
require "SQLconnect.php";

use mysqli;
class main extends SQLconnect{
    private $mysqli;
    public function __construct(){
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        try {
            $this->mysqli = new mysqli($this->host, $this->user, $this->mdp, $this->db, $this->port);
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





