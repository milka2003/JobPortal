<?php
session_start();
// Check if job seeker is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'job_seeker') {
header('Location: login.php'); // Redirect to login if not a job seeker
exit;
}
require_once 'includes/db.php'; // Include the database connection
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
// Ensure that job_id is provided
if (isset($_POST['job_id'])) {
$job_id = $_POST['job_id'];
$user_id = $_SESSION['user_id'];
// Insert application into the database
$stmt = $pdo->prepare("INSERT INTO applications (user_id, job_id) VALUES (?, ?)");
$stmt->execute([$user_id, $job_id]);
$message = "You have successfully applied for the job!";
} else {
$message = "Job ID is missing. Please try again.";
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Apply for Job</title>
<link rel="stylesheet" href="assests/css/style.css"> <!-- Corrected assets path -->
</head>
<body>
<div class="container">
<h1>Apply for Job</h1>
<!-- Show success or error message -->
<?php if (isset($message)): ?>
<p class="success-message"><?php echo htmlspecialchars($message); ?></p>
<?php endif; ?>
<a href="browse-jobs.php" class="button">Go Back to Browse Jobs</a>
</div>
<script src="assests/js/scripts.js"></script> <!-- Corrected assets path -->
</body>
</html>