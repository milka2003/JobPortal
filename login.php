<?php

// Start session to manage login and logout messages
session_start();

// Check if there is a logout message to display
if (isset($_SESSION['logout_message'])) {
    $logout_message = $_SESSION['logout_message'];
    unset($_SESSION['logout_message']);  // Clear message after displaying it
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Include the database connection
    require_once 'includes/db.php';

    // Check if user exists by email
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // Verify password and log the user in if correct
    if ($user && password_verify($password, $user['password'])) {
        // If the password matches the hash, start the session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];  // "job_seeker" or "employer"
        header('Location: dashboard.php');  // Redirect to the dashboard after successful login
        exit;
    } else {
        // Show an error if credentials are incorrect
        $error_message = "Invalid credentials, please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assests/css/style.css"> <!-- Include CSS -->
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>

        <!-- Display logout message if it exists -->
        <?php if (isset($logout_message)): ?>
            <p class="success"><?php echo htmlspecialchars($logout_message); ?></p>
        <?php endif; ?>

        <!-- Display error message if login fails -->
        <?php if (isset($error_message)): ?>
            <p class="error"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>

        <!-- Login form -->
        <form method="POST" action="login.php" id="loginForm">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" placeholder="Email" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" placeholder="Password" required>

            <button type="submit" class="button">Login</button>
        </form>
    </div>

    <script src="assests/js/scripts.js"></script> <!-- Include JavaScript -->
</body>
</html>
