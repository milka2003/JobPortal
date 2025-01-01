<?php
// Database connection settings
$host = 'localhost';   // For local development
$dbname = 'job_portal'; // Name of the database
$username = 'root';     // Default MySQL username in XAMPP
$password = '';         // Default MySQL password in XAMPP (empty)

try {
    // Create PDO instance to connect to MySQL
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // If the connection fails, show the error message
    die("Connection failed: " . $e->getMessage());
}
?>
