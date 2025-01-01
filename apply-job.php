<?php
session_start();

// Check if job seeker is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'job_seeker') {
    header('Location: login.php');  // Redirect to login if not a job seeker
    exit;
}

require_once 'includes/db.php'; // Include the database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['job_id'])) {
    $job_id = $_POST['job_id'];
    $user_id = $_SESSION['user_id'];
    $cover_letter = $_POST['cover_letter'] ?? '';
    
    // Check if already applied
    $stmt = $pdo->prepare("SELECT id FROM applications WHERE user_id = ? AND job_id = ?");
    $stmt->execute([$user_id, $job_id]);
    if (!$stmt->fetch()) {
        // Insert application
        $stmt = $pdo->prepare("INSERT INTO applications (user_id, job_id, cover_letter) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $job_id, $cover_letter]);
        $message = "You have successfully applied for the job!";
    } else {
        $message = "You have already applied for this job.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for Job</title>
    <link rel="stylesheet" href="assests/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Apply for Job</h1>
        <?php if (isset($message)): ?>
            <p class="message"><?php echo htmlspecialchars($message); ?></p>
        <?php else: ?>
            <form method="POST" class="application-form">
                <input type="hidden" name="job_id" value="<?php echo htmlspecialchars($_GET['job_id'] ?? ''); ?>">
                <textarea name="cover_letter" placeholder="Write your cover letter here..." rows="10" required></textarea>
                <button type="submit" class="button">Submit Application</button>
            </form>
        <?php endif; ?>
        
        <a href="browse-jobs.php" class="button">Back to Jobs</a>
    </div>
</body>
</html>