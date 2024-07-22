<?php

$hostname = "localhost";
$username = "root";
$password = "";
$database = "s_parser";

// $hostname = "localhost";
// $username = "dindilon20_1";
// $password = "1ALCMbKGC%DTYSVC";
// $database = "dindilon20_1";

$mysqli = mysqli_connect($hostname, $username, $password, $database);

if (!$mysqli) {
    die('Error connect to DataBase');
} else {
    //    echo "Successful connect to Data Base";
}
