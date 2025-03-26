<?php
$host = "dpg-cvhs6ndrie7s73ea3ls0-a"
$port = "5432";                // Default PostgreSQL port
$dbname = "onlineexam";
$user = "onlineexam_user";
$password = "";

// Create connection using PDO
try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;";
    $conn = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    echo "Connected to PostgreSQL successfully!";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>

