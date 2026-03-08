<?php

$mysqli = new mysqli("172.19.80.1", "adm", "SUPERADMIN", "bdd_web", 3306);
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}