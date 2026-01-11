<?php
$servername = "127.0.0.1";
$username   = "root";   // default XAMPP user
$password   = "";       // default XAMPP password is empty
$dbname     = "food_delivery";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
