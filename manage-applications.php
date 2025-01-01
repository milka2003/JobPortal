<form method="POST" class="status-update-form">
                            <input type="hidden" name="application_id" value="<?php echo $app['application_id']; ?>">
                            <select name="new_status" required>
                                <option value="pending" <?php echo $app['application_status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="reviewing" <?php echo $app['application_status'] == 'reviewing' ? 'selected' : ''; ?>>Reviewing</option>
                                <option value="shortlisted" <?php echo $app['application_status'] == 'shortlisted' ? 'selected' : ''; ?>>Shortlisted</option>
                                <option value="rejected" <?php echo $app['application_status'] == 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                                <option value="accepted" <?php echo $app['application_status'] == 'accepted' ? 'selected' : ''; ?>>Accepted</option>
                            </select>
                            <button type="submit" name="update_status" class="button">Update Status</button>
                        </form>
                    </div>
                    <?php if (!empty($applications)) { ?>
                <div class="applications-list">
                    <?php foreach ($applications as $app) { ?>
                        <div class="application-item">
                            <h3>Job: <?php echo htmlspecialchars($app['job_title']); ?></h3>
                            <p><strong>Applicant:</strong> <?php echo htmlspecialchars($app['applicant_name']); ?></p>
                            <!-- ... rest of your application display code ... -->
                        </div>
                    <?php } ?>
                </div>
            <?php } else { ?>
                <p>No applications received yet.</p>
            <?php } ?>
        <a href="dashboard.php" class="button">Back to Dashboard</a>
    </div>
</body>
</html>
