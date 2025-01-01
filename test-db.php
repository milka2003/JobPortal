<?php
require_once 'includes/db.php'; // Include the database connection file

// Try to fetch something from the database to test the connection
try {
    $stmt = $pdo->query("SELECT * FROM users"); // Try to select from the users table
    $users = $stmt->fetchAll();
    echo "Connection successful!<br>";
    echo "Users in the database: <br>";
    print_r($users); // Print the users (it should be empty for now)
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
