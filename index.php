<?php
session_start();

// Include the database connection
require_once 'includes/db.php';

// Check if user is logged in
$isLoggedIn = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);

// Fetch job listings
$jobs = [];
if ($isLoggedIn) {
    try {
        $stmt = $pdo->query("SELECT * FROM jobs ORDER BY id DESC LIMIT 5");
        $jobs = $stmt->fetchAll();
    } catch (PDOException $e) {
        // Handle database error gracefully
        $jobs = [];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Portal - Find Your Dream Job</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assests/css/style.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <h2>Job Portal</h2>
            </div>
            <div class="nav-links">
                <?php if ($isLoggedIn): ?>
                    <a href="dashboard.php">Dashboard</a>
                    <a href="logout.php" class="button">Logout</a>
                <?php else: ?>
                    <a href="login.php">Login</a>
                    <a href="register.php" class="button">Register</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>

    <main>
        <div class="hero-section">
            <div class="hero-content">
                <h1>Find Your Dream Job</h1>
                <p>Connect with the best opportunities and take the next step in your career journey.</p>
                <?php if (!$isLoggedIn): ?>
                    <div class="hero-buttons">
                        <a href="register.php" class="button">Get Started</a>
                        <a href="login.php" class="button">Sign In</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="container">
            <?php if ($isLoggedIn): ?>
                <section class="recent-jobs">
                    <h2>Recent Job Listings</h2>
                    <?php if (!empty($jobs)): ?>
                        <div class="job-list">
                            <?php foreach ($jobs as $job): ?>
                                <div class="job-item">
                                    <h3><?php echo htmlspecialchars($job['title']); ?></h3>
                                    <p><?php echo htmlspecialchars($job['description']); ?></p>
                                    <p><strong>Location:</strong> <?php echo htmlspecialchars($job['location']); ?></p>
                                    <p><strong>Salary:</strong> $<?php echo htmlspecialchars($job['salary']); ?></p>
                                    <form method="POST" action="apply-job.php">
                                        <input type="hidden" name="job_id" value="<?php echo $job['id']; ?>">
                                        <button type="submit" class="button">Apply Now</button>
                                    </form>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p>No jobs available at the moment.</p>
                    <?php endif; ?>
                </section>
            <?php else: ?>
                <section class="features">
                    <h2>Why Choose Us</h2>
                    <div class="features-grid">
                        <div class="feature-item">
                            <h3>Find Perfect Matches</h3>
                            <p>Discover opportunities that align with your skills and career goals.</p>
                        </div>
                        <div class="feature-item">
                            <h3>Easy Application</h3>
                            <p>Apply to multiple jobs with just a few clicks.</p>
                        </div>
                        <div class="feature-item">
                            <h3>Track Applications</h3>
                            <p>Keep track of your job applications in one place.</p>
                        </div>
                    </div>
                </section>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Job Portal. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>