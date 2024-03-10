<?php
$sname = "localhost";
$uname = "root";
$password = "";
$db_name = "fitcheck";

// Create connection
$conn = new mysqli($sname, $uname, $password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
