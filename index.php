<?php
session_start();

// Include the database connection
require_once 'includes/db.php';

// Improved session verification
$isLoggedIn = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);

// Clear session if needed (uncomment these lines if you want to force logout)
// session_destroy();
// $isLoggedIn = false;

// Fetch job listings only if logged in
$jobs = [];
if ($isLoggedIn) {
    try {
        $stmt = $pdo->query("SELECT * FROM jobs");
        $jobs = $stmt->fetchAll();
    } catch (PDOException $e) {
        $jobs = [];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assests/css/style.css">
</head>
<body>
    <header>
        <h1>Welcome to the Job Portal</h1>
        <nav>
            <?php if ($isLoggedIn): ?>
                <a href="dashboard.php">Dashboard</a> |
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a> |
                <a href="register.php">Register</a>
            <?php endif; ?>
        </nav>
    </header>

    <main>
        <?php if ($isLoggedIn): ?>
            <h2>Available Job Listings</h2>
            <?php if (!empty($jobs)): ?>
                <ul>
                    <?php foreach ($jobs as $job): ?>
                        <li>
                            <h3><?php echo htmlspecialchars($job['title']); ?></h3>
                            <p><?php echo htmlspecialchars($job['description']); ?></p>
                            <p><strong>Location:</strong> <?php echo htmlspecialchars($job['location']); ?></p>
                            <p><strong>Salary:</strong> $<?php echo htmlspecialchars($job['salary']); ?></p>
                            <form method="POST" action="apply-job.php">
                                <input type="hidden" name="job_id" value="<?php echo $job['id']; ?>">
                                <button type="submit">Apply Now</button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No jobs available at the moment.</p>
            <?php endif; ?>
        <?php else: ?>
            <h2>Connect with Opportunities That Matter</h2>
            
        <?php endif; ?>
    </main>
</body>
</html>