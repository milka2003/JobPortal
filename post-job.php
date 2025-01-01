<?php
session_start();

// Check if employer is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'employer') {
    header('Location: login.php');  // Redirect to login if not an employer
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $salary = $_POST['salary'];
    $status = $_POST['status']; // New status field
    
    require_once 'includes/db.php';
    $stmt = $pdo->prepare("INSERT INTO jobs (title, description, location, salary, status, employer_id) 
                          VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$title, $description, $location, $salary, $status, $_SESSION['user_id']]);
    
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
        <h2>Post a Job</h2>
        <?php if (isset($success_message)): ?>
            <p class="success"><?php echo htmlspecialchars($success_message); ?></p>
        <?php endif; ?>
        
        <form method="POST" action="post-job.php" id="postJobForm">
            <input type="text" name="title" placeholder="Job Title" required>
            <textarea name="description" placeholder="Job Description" required></textarea>
            <input type="text" name="location" placeholder="Location">
            <input type="number" name="salary" placeholder="Salary" min="0">
            <select name="status" required>
                <option value="active">Active</option>
                <option value="draft">Draft</option>
                <option value="closed">Closed</option>
            </select>
            <button type="submit" class="button">Post Job</button>
        </form>
    </div>
</body>
</html>
