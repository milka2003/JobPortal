<?php
// Start session to store registration state
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role']; // "job_seeker" or "employer"

    // Input validation
    if (empty($username) || empty($email) || empty($password)) {
        $error_message = "All fields are required.";
    } else {
        // Include the database connection
        require_once 'includes/db.php';

        // Check if the email is already registered
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $existingUser = $stmt->fetch();

        if ($existingUser) {
            $error_message = "Email is already registered. Please use a different email.";
        } else {
            // Hash the password before storing it
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Insert the new user into the database
            $sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$username, $email, $hashedPassword, $role]);

            $success_message = "Registration successful! Please <a href='login.php'>login</a>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assests/css/style.css"> <!-- Include CSS -->
</head>
<body>
    <div class="register-container">
        <h2>Register</h2>

        <!-- Display error message if registration fails -->
        <?php if (isset($error_message)): ?>
            <p class="error"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>

        <!-- Display success message if registration is successful -->
        <?php if (isset($success_message)): ?>
            <p class="success"><?php echo $success_message; ?></p>
        <?php endif; ?>

        <!-- Registration Form -->
        <form method="POST" action="register.php" id="registerForm">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" placeholder="Username" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" placeholder="Email" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" placeholder="Password" required>

            <label for="role">Role:</label>
            <select name="role" id="role">
                <option value="job_seeker">Job Seeker</option>
                <option value="employer">Employer</option>
            </select>

            <button type="submit" class="button">Register</button>
        </form>
    </div>

    <script src="assests/js/scripts.js"></script> <!-- Include JavaScript -->
</body>
</html>