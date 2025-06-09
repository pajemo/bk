<?php
require 'config.php';

// Define old superuser email to delete
$oldEmail = 'superuser@example.com';

// Delete old superuser from database
$stmt = $conn->prepare("DELETE FROM users WHERE email = ?");
$stmt->bind_param("s", $oldEmail);
if ($stmt->execute()) {
    echo "Old superuser account deleted successfully.";
} else {
    echo "Error deleting old superuser account: " . $stmt->error;
}
?>
</create_file>
