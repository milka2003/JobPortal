<?php
// manage-jobs.php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'employer') {
    header('Location: login.php');
    exit;
}
require_once 'includes/db.php';

// Delete operation
if (isset($_POST['delete_job'])) {
    $job_id = $_POST['job_id'];
    $employer_id = $_SESSION['user_id'];
    $stmt = $pdo->prepare("DELETE FROM jobs WHERE id = ? AND employer_id = ?");
    $stmt->execute([$job_id, $employer_id]);
    header('Location: manage-jobs.php');
    exit;
}

// Fetch employer's jobs
$stmt = $pdo->prepare("SELECT * FROM jobs WHERE employer_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$jobs = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Jobs</title>
    <link rel="stylesheet" href="assests/css/style.css">
</head>
<body>
    <div class="container">
        <!-- Navigation Menu -->
        <nav class="navigation-menu">
            <a href="post-job.php" class="button">Post New Job</a>
            <a href="logout.php" class="button">Logout</a>
        </nav>

        <h1>Manage Your Job Postings</h1>
        
        <?php if (!empty($jobs)): ?>
            <div class="jobs-list">
                <?php foreach ($jobs as $job): ?>
                    <div class="job-item">
                        <h3><?php echo htmlspecialchars($job['title']); ?></h3>
                        <p><?php echo htmlspecialchars($job['description']); ?></p>
                        <p><strong>Location:</strong> <?php echo htmlspecialchars($job['location']); ?></p>
                        <p><strong>Salary:</strong> $<?php echo htmlspecialchars($job['salary']); ?></p>
                        <div class="job-actions">
                            <a href="edit-job.php?id=<?php echo $job['id']; ?>" class="button">Edit</a>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="job_id" value="<?php echo $job['id']; ?>">
                                <button type="submit" name="delete_job" class="button delete"
                                    onclick="return confirm('Are you sure you want to delete this job?')">Delete</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>You haven't posted any jobs yet.</p>
        <?php endif; ?>
    </div>
</body>
</html>
