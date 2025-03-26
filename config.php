<?php
$servername = "127.0.0.1";  // Use only the IP, without port
$port = "3307";             // Define the port separately
$username = "root";
$password = "";
$dbname = "onlineexam";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
