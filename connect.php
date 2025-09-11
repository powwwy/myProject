<?php
$database="myproject";
$server= "localhost";
$username = "root";
$password = "";
$conn = new mysqli($server, $username, $password, $database, 3308);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>