<?php

$sname= "localhost";
$uname= "root";
$password = "";
$db_name = "fitcheck";

if (!$conn = mysqli_connect($sname, $uname, $password, $db_name)) {
    die("Connection failed!");
}