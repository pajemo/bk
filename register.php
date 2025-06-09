<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Pajemo Bank</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
require 'config.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = trim($_POST['first_name']);
    $surname = trim($_POST['surname']);
    $dob = $_POST['dob'];
    $address = trim($_POST['address']);
    $phone = trim($_POST['phone']);
    $idType = $_POST['id_type'];
    $idNumber = trim($_POST['id_number']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format.";
    } elseif (!preg_match($pattern, $password)) {
        $message = "Password must be at least 6 characters, include uppercase, lowercase, number, and special character.";
    } elseif ($password !== $confirm_password) {
        $message = "Passwords do not match.";
    } elseif (!isset($_FILES['id_upload']) || $_FILES['id_upload']['error'] !== UPLOAD_ERR_OK) {
        $message = "Please upload a valid ID file.";
    } else {
        // Handle file upload
        $uploadDir = 'uploads/ids/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $fileTmpPath = $_FILES['id_upload']['tmp_name'];
        $fileName = basename($_FILES['id_upload']['name']);
        $fileSize = $_FILES['id_upload']['size'];
        $fileType = $_FILES['id_upload']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        $destPath = $uploadDir . $newFileName;

        $allowedExtensions = array('jpg', 'jpeg', 'png', 'pdf');
        if (!in_array($fileExtension, $allowedExtensions)) {
            $message = "Upload failed. Allowed file types: " . implode(", ", $allowedExtensions);
        } else {
            if (move_uploaded_file($fileTmpPath, $destPath)) {
                // Check if email already exists
                $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $message = "Email already registered.";
                } else {
                    // Insert user with new fields
                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
$stmt = $conn->prepare("INSERT INTO users (FirstName, Surname, DateOfBirth, Address, PhoneNumber, IDType, IDNumber, IDUpload, Email, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssssss", $firstName, $surname, $dob, $address, $phone, $idType, $idNumber, $newFileName, $email, $passwordHash);
                    if ($stmt->execute()) {
                        $userID = $conn->insert_id;

                        // Generate verification code
                        $code = generateCode(20);
                        $expiry = date('Y-m-d H:i:s', strtotime('+1 day'));

                        // Insert verification code
$stmt = $conn->prepare("INSERT INTO emailverifications (user_id, VerificationCode, Expiry) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $userID, $code, $expiry);
                        $stmt->execute();

                        // Send verification email
                        $verificationLink = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/verify_email.php?code=$code";
                        $subject = "Verify your email";
                        $body = "Please click the following link to verify your email: <a href='$verificationLink'>$verificationLink</a>";

                        if (sendEmail($email, $subject, $body)) {
                            $message = "Registration successful! Please check your email to verify your account.";
                        } else {
                            $message = "Failed to send verification email.";
                        }
                    } else {
                        $message = "Failed to register user.";
                    }
                }
            } else {
                $message = "There was an error moving the uploaded file.";
            }
        }
    }
}
?>

<?php include 'header.php'; ?>

<div class="content">
    <h1>Register</h1>
    <?php if ($message): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
    <form method="post" action="register.php" enctype="multipart/form-data" onsubmit="return validatePasswords()">
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" required>
        <label for="surname">Surname:</label>
        <input type="text" id="surname" name="surname" required>
        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="dob" required>
        <label for="address">Address:</label>
        <textarea id="address" name="address" rows="3" required></textarea>
        <label for="phone">Phone Number:</label>
        <input type="tel" id="phone" name="phone" required pattern="^\+?[0-9\s\-]{7,15}$" title="Enter a valid phone number">
        <label>ID Type:</label>
        <input type="radio" id="passport" name="id_type" value="passport" required>
        <label for="passport">Passport</label>
        <input type="radio" id="driver_license" name="id_type" value="driver_license" required>
        <label for="driver_license">Driver's License</label>
        <input type="radio" id="national_id" name="id_type" value="national_id" required>
        <label for="national_id">National ID</label>
        <label for="id_number">ID Number:</label>
        <input type="text" id="id_number" name="id_number" required>
        <label for="id_upload">Upload ID for Verification:</label>
        <input type="file" id="id_upload" name="id_upload" accept=".jpg,.jpeg,.png,.pdf" required>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required minlength="6" pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}" title="Must be at least 6 characters, include uppercase, lowercase, number, and special character">
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required minlength="6" pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}" title="Must be at least 6 characters, include uppercase, lowercase, number, and special character">
        <input type="submit" value="Register">
    </form>
    <p>Already have an account? <a href="login.php">Login here</a>.</p>
</div>
<script>
function validatePasswords() {
    var password = document.getElementById("password").value;
    var confirm_password = document.getElementById("confirm_password").value;
    if (password !== confirm_password) {
        alert("Passwords do not match.");
        return false;
    }
    return true;
}
</script>
<?php include 'footer.php'; ?>
</body>
</html>
