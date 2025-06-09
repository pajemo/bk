<?php
require 'config.php';

// Define superuser details
$email = 'superuser@example.com';
$password = password_hash('SuperSecretPassword123', PASSWORD_DEFAULT);
$role = 'super_admin';

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if superuser already exists
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("s", $email);
if (!$stmt->execute()) {
    die("Execute failed: " . $stmt->error);
}
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    echo "Superuser already exists.";
} else {
    // Insert superuser into database
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role, email_verified_at, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW(), NOW())");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $name = 'Superuser';
    $stmt->bind_param("ssss", $name, $email, $password, $role);
    if ($stmt->execute()) {
        echo "Superuser account created successfully.";
    } else {
        echo "Error creating superuser account: " . $stmt->error;
    }
}
?>
