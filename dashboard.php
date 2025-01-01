<?php

session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');  // Redirect to login if not logged in
    exit;
}

require_once 'includes/db.php'; // Include the database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assests/css/style.css"> <!-- Include CSS -->
</head>
<body>
    <div class="container">
        <h1>Welcome</h1>
        <p>You are logged in as <?php echo htmlspecialchars($_SESSION['role']); ?></p>

        <!-- Display user-specific content -->
        <?php if ($_SESSION['role'] == 'employer'): ?>
            <a href="post-job.php" class="button">Post a New Job</a>
            <a href="manage-jobs.php" class="button">Manage Jobs</a>  <!-- Link to post a job -->
        <?php endif; ?>

        <?php if ($_SESSION['role'] == 'job_seeker'): ?>
            <a href="browse-jobs.php" class="button">Browse Jobs</a> 
             <!-- Link to browse and apply for jobs -->
        <?php endif; ?>

        <a href="logout.php" class="button logout-button">Logout</a>  <!-- Logout link -->
    </div>

    <script src="assests/js/scripts.js"></script> <!-- Include JavaScript -->
</body>
</html>
