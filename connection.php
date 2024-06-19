<?php
$servername = "localhost";
$username = "id22333213_kostgasrental";
$password = "Vinturbodiesel1[";
$dbname = "id22333213_kostgas";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
