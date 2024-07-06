<?php

$hostname = "localhost";
$username = "root";
$password = "";
$database = "s_parser";

$mysqli = mysqli_connect($hostname, $username, $password, $database);

if (!$mysqli) {
    die('Error connect to DataBase');
} else {
    //    echo "Successful connect to Data Base";
}
