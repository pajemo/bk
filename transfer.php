<?php
include 'header.php';
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userID = $_SESSION['user_id'];
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recipientBankAccount = trim($_POST['recipient_bank_account']);
    $recipientBankName = trim($_POST['recipient_bank_name']);
    $recipientAccountName = trim($_POST['recipient_account_name']);
    $routingNumber = trim($_POST['routing_number']);
    $swiftBIC = trim($_POST['swift_bic']);
    $amount = floatval($_POST['amount']);

    if (empty($recipientBankAccount) || empty($recipientBankName) || empty($recipientAccountName)) {
        $message = "Please enter recipient bank account details.";
    } elseif ($amount <= 0) {
        $message = "Please enter a valid amount.";
    } else {
        // Fetch sender account and balance
        $stmt = $conn->prepare("SELECT AccountID, Balance FROM accounts WHERE user_id = ?");
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $result = $stmt->get_result();
        $senderAccount = $result->fetch_assoc();

        if (!$senderAccount) {
            $message = "Sender account not found.";
        } elseif ($amount > $senderAccount['Balance']) {
            $message = "Insufficient balance.";
        } else {
            // Fetch recipient account by bank account number and bank name
            $stmt = $conn->prepare("SELECT AccountID, user_id FROM accounts WHERE AccountNumber = ? AND BankName = ?");
            $stmt->bind_param("ss", $recipientBankAccount, $recipientBankName);
            $stmt->execute();
            $result = $stmt->get_result();
            $recipientAccount = $result->fetch_assoc();

            if ($recipientAccount) {
                // Internal transfer
                $conn->begin_transaction();

                try {
                    // Deduct from sender
                    $stmt = $conn->prepare("UPDATE accounts SET Balance = Balance - ? WHERE AccountID = ?");
                    $stmt->bind_param("di", $amount, $senderAccount['AccountID']);
                    $stmt->execute();

                    // Add to recipient
                    $stmt = $conn->prepare("UPDATE accounts SET Balance = Balance + ? WHERE AccountID = ?");
                    $stmt->bind_param("di", $amount, $recipientAccount['AccountID']);
                    $stmt->execute();

                    // Insert sender transaction
                    $stmt = $conn->prepare("INSERT INTO transactions (AccountID, TransactionType, Amount, TransactionDate) VALUES (?, 'Transfer Out', ?, NOW())");
                    $stmt->bind_param("id", $senderAccount['AccountID'], $amount);
                    $stmt->execute();

                    // Insert recipient transaction
                    $stmt = $conn->prepare("INSERT INTO transactions (AccountID, TransactionType, Amount, TransactionDate) VALUES (?, 'Transfer In', ?, NOW())");
                    $stmt->bind_param("id", $recipientAccount['AccountID'], $amount);
                    $stmt->execute();

                    $conn->commit();
                    $message = "Transfer successful.";
                } catch (Exception $e) {
                    $conn->rollback();
                    $message = "Transfer failed: " . $e->getMessage();
                }
            } else {
                // External transfer
                $conn->begin_transaction();

                try {
                    // Deduct from sender
                    $stmt = $conn->prepare("UPDATE accounts SET Balance = Balance - ? WHERE AccountID = ?");
                    $stmt->bind_param("di", $amount, $senderAccount['AccountID']);
                    $stmt->execute();

                    // Insert sender transaction
                    $stmt = $conn->prepare("INSERT INTO transactions (AccountID, TransactionType, Amount, TransactionDate) VALUES (?, 'Transfer Out', ?, NOW())");
                    $stmt->bind_param("id", $senderAccount['AccountID'], $amount);
                    $stmt->execute();

                    // Insert external transfer record
                    $stmt = $conn->prepare("INSERT INTO ExternalTransfers (SenderAccountID, RecipientBankAccount, RecipientBankName, RecipientAccountName, RoutingNumber, SwiftBIC, Amount, TransferDate) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
                    $stmt->bind_param("issssss", $senderAccount['AccountID'], $recipientBankAccount, $recipientBankName, $recipientAccountName, $routingNumber, $swiftBIC, $amount);
                    $stmt->execute();

                    $conn->commit();
                    $message = "External transfer successful.";
                } catch (Exception $e) {
                    $conn->rollback();
                    $message = "External transfer failed: " . $e->getMessage();
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Funds Transfer - Bank Website</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Funds Transfer</h2>
    <?php if ($message): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
    <form method="post" action="transfer.php">
        <label>Account Number:</label><br>
        <input type="text" name="recipient_bank_account" required><br><br>
        <label>Bank Name:</label><br>
        <input type="text" name="recipient_bank_name" required><br><br>
        <label>Account Name:</label><br>
        <input type="text" name="recipient_account_name" required><br><br>
        <label>Routing Number:</label><br>
        <input type="text" name="routing_number" required><br><br>
        <label>SWIFT/BIC:</label><br>
        <input type="text" name="swift_bic" required><br><br>
        <label>Amount:</label><br>
        <input type="number" step="0.01" name="amount" required><br><br>
        <input type="submit" value="Transfer">
    </form>
    <p><a href="dashboard.php">Back to Dashboard</a></p>
<?php include 'footer.php'; ?>
</body>
</html>
