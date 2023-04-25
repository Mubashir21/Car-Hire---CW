<?php 

// used to connect to the database

$servername = "localhost";
$dBUsername = "root";
$dBPassword = "";
$dBName = "COMP1044_database";

$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

if (!$conn) {
    die("Connection failed: ".mysqli_connect_error());
}

?>