<?php
$host = "localhost";
$username = "simon";
$password = "simonko4444";
$database = "eshop";

$conn = mysqli_connect($host , $username, $password, $database);
if ($conn -> connect_errno) {
    echo "Failed to connect to MySQL: " . $conn -> connect_error;
    exit();
}

?>