<?php
// edit-job.php - For updating existing job postings
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'employer') {
    header('Location: login.php');
    exit;
}

require_once 'includes/db.php';

$job_id = $_GET['id'] ?? null;
if (!$job_id) {
    header('Location: manage-jobs.php');
    exit;
}

// Fetch existing job data
$stmt = $pdo->prepare("SELECT * FROM jobs WHERE id = ? AND employer_id = ?");
$stmt->execute([$job_id, $_SESSION['user_id']]);
$job = $stmt->fetch();

if (!$job) {
    header('Location: manage-jobs.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $salary = $_POST['salary'];
    
    $stmt = $pdo->prepare("UPDATE jobs SET title = ?, description = ?, location = ?, salary = ? WHERE id = ? AND employer_id = ?");
    $stmt->execute([$title, $description, $location, $salary, $job_id, $_SESSION['user_id']]);
    
    header('Location: manage-jobs.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Job</title>
    <link rel="stylesheet" href="assests/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Edit Job Posting</h1>
        <form method="POST" action="edit-job.php?id=<?php echo $job_id; ?>" class="edit-job-form">
            <div class="form-group">
                <label for="title">Job Title:</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($job['title']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="description">Job Description:</label>
                <textarea id="description" name="description" required><?php echo htmlspecialchars($job['description']); ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="location">Location:</label>
                <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($job['location']); ?>">
            </div>
            
            <div class="form-group">
                <label for="salary">Salary:</label>
                <input type="number" id="salary" name="salary" value="<?php echo htmlspecialchars($job['salary']); ?>" min="0">
            </div>
            
            <div class="form-actions">
                <button type="submit" class="button">Update Job</button>
                <a href="manage-jobs.php" class="button cancel">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>