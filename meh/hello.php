<?php
print "Hello, World!\n";
print "<br>";
print "Today is " . date("26-m-Y") . "\n";

echo "<br>";

$server= "localhost";
$username = "root"; 
$password = "";
$dbname = "testdb";

$conn = new mysqli($server, $username, $password, $dbname, 3308);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
$conn->close();
?>