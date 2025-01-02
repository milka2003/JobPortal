<?php
// browse-jobs.php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'job_seeker') {
    header('Location: login.php');
    exit;
}
require_once 'includes/db.php';

// Fetch all job listings
$stmt = $pdo->query("SELECT * FROM jobs ORDER BY id DESC");
$jobs = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Jobs</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assests/css/style.css">
</head>
<body>
    <div class="container">
        <!-- Navigation Menu -->
        <nav class="navigation-menu">
            <a href="logout.php" class="button">Logout</a>
        </nav>

        <h1>Browse Jobs</h1>
        
        <?php if (count($jobs) > 0): ?>
            <ul class="job-list">
                <?php foreach ($jobs as $job): ?>
                    <li class="job-item">
                        <h3><?php echo htmlspecialchars($job['title']); ?></h3>
                        <p><?php echo htmlspecialchars($job['description']); ?></p>
                        <p><strong>Location:</strong> <?php echo htmlspecialchars($job['location']); ?></p>
                        <p><strong>Salary:</strong> $<?php echo htmlspecialchars($job['salary']); ?></p>
                        <form method="POST" action="apply-job.php">
                            <input type="hidden" name="job_id" value="<?php echo $job['id']; ?>">
                            <button type="submit" class="button">Apply Now</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No jobs available at the moment. Please check back later.</p>
        <?php endif; ?>
    </div>
</body>
</html>

