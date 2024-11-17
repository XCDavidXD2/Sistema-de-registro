<?php
$servername = "db";
$username = "myuser";
$password = "mypassword";
$dbname = "mydatabase";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Error de conexión: " . $conn->connect_error);
}
echo "<br>";
?>