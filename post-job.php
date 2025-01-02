<?php
// post-job.php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'employer') {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once 'includes/db.php';
    
    // Collect form data
    $title = $_POST['title'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $salary = $_POST['salary'];

    // Insert job posting into the database
    $stmt = $pdo->prepare("INSERT INTO jobs (title, description, location, salary, employer_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$title, $description, $location, $salary, $_SESSION['user_id']]);
    $success_message = "Job posted successfully!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post a Job</title>
    <link rel="stylesheet" href="assests/css/style.css">
</head>
<body>
    <div class="post-job-container">
        <!-- Navigation Menu -->
        <nav class="navigation-menu">
            <a href="manage-jobs.php" class="button">Manage Jobs</a>
            <a href="logout.php" class="button">Logout</a>
        </nav>

        <h2>Post a Job</h2>
        
        <?php if (isset($success_message)): ?>
            <p class="success"><?php echo htmlspecialchars($success_message); ?></p>
        <?php endif; ?>

        <form method="POST" action="post-job.php" id="postJobForm">
            <div class="form-group">
                <label for="title">Job Title:</label>
                <input type="text" id="title" name="title" required>
            </div>

            <div class="form-group">
                <label for="description">Job Description:</label>
                <textarea id="description" name="description" required></textarea>
            </div>

            <div class="form-group">
                <label for="location">Location:</label>
                <input type="text" id="location" name="location" required>
            </div>

            <div class="form-group">
                <label for="salary">Salary:</label>
                <input type="number" id="salary" name="salary" min="0" required>
            </div>

            <button type="submit" class="button">Post Job</button>
        </form>
    </div>
</body>
</html>

