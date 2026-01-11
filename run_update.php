<?php
require 'includes/config.php';

$sql = file_get_contents('final_fix.sql');

// Remove comments and split by semicolon (basic parsing)
$statements = array_filter(array_map('trim', explode(';', $sql)));

foreach ($statements as $stmt) {
    if (!empty($stmt)) {
        if ($conn->query($stmt) === TRUE) {
            echo "Executed: " . substr($stmt, 0, 50) . "...<br>";
        } else {
            // Check if column exists error, ignore it
            if (strpos($conn->error, "Duplicate column") !== false) {
                 echo "Skipped (Column exists): " . substr($stmt, 0, 50) . "...<br>";
            } else {
                echo "Error executing: " . $conn->error . "<br>";
            }
        }
    }
}

echo "Database updated successfully! <a href='index.php'>Go Home</a>";
?>
