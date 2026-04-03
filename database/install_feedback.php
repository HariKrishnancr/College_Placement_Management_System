<?php
// Script to install feedback table in the database

require_once("../db.php");

echo "<h2>Installing Feedback Table...</h2>";

// SQL to create feedback table
$sql1 = "CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `admin_response` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `response_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if ($conn->query($sql1) === TRUE) {
    echo "<p style='color: green;'>✓ Feedback table created successfully!</p>";
} else {
    echo "<p style='color: red;'>✗ Error creating feedback table: " . $conn->error . "</p>";
}

// SQL to add foreign key constraint
$sql2 = "ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE";

// Check if constraint already exists
$check_constraint = "SELECT CONSTRAINT_NAME 
                     FROM information_schema.TABLE_CONSTRAINTS 
                     WHERE TABLE_SCHEMA = 'placement' 
                     AND TABLE_NAME = 'feedback' 
                     AND CONSTRAINT_NAME = 'feedback_ibfk_1'";

$result = $conn->query($check_constraint);

if ($result->num_rows == 0) {
    if ($conn->query($sql2) === TRUE) {
        echo "<p style='color: green;'>✓ Foreign key constraint added successfully!</p>";
    } else {
        echo "<p style='color: orange;'>⚠ Note: Foreign key constraint may already exist or error occurred: " . $conn->error . "</p>";
    }
} else {
    echo "<p style='color: blue;'>ℹ Foreign key constraint already exists.</p>";
}

echo "<h3>Installation Complete!</h3>";
echo "<p>You can now use the feedback feature:</p>";
echo "<ul>";
echo "<li><a href='../user/feedback.php'>Student Feedback Page</a></li>";
echo "<li><a href='../admin/feedback.php'>Admin Feedback Management</a></li>";
echo "</ul>";

$conn->close();
?>
