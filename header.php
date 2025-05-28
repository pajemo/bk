<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<nav>
    <ul>
        <li><a href="index.php">Home</a></li>
        <?php if (isset($_SESSION['user_id'])): ?>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="deposit.php">Deposit</a></li>
            <li><a href="withdrawal.php">Withdrawal</a></li>
            <li><a href="transfer.php">Transfer</a></li>
            <li><a href="logout.php">Logout</a></li>
        <?php else: ?>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="about.php">About Us</a></li>
            <li><a href="gpt.php"></a></li>
        <?php endif; ?>
    </ul>
</nav>

<?php if (!isset($_SESSION['user_id'])): ?>
<div class="nav-links" style="display: flex; justify-content: space-between; align-items: center; gap: 20px;">
    <div style="flex-shrink: 0;">
        <a href="index.php"><img src="images/logo.png" alt="Pajemo Bank Logo" style="height: 40px;"></a>
    </div>
    <div style="display: flex; gap: 20px; align-items: center; justify-content: space-between; width: 100%;">
        <span style="margin-right: 20px;">
            <i class="bi bi-telephone-fill"></i> +1 (555) 123-4567 &nbsp; | &nbsp; 
            <i class="bi bi-envelope-fill"></i> support@pajemobank.com
        </span>
        <div>
            <a href="login.php" style="display: inline-block; margin-right: 10px;">Login</a>
            <a href="register.php" style="display: inline-block;">Register</a>
        </div>
    </div>
</div>
<?php endif; ?>

<link rel="stylesheet" href="style.css">

<style>
nav ul {
    list-style-type: none;
    padding: 0;
    margin: 0 0 20px 0;
    background-color: var(--primary-color);
    overflow: hidden;
    display: flex;
    justify-content: center;
}

nav ul li {
    /* float: left; */
    margin: 0 10px;
}

nav ul li a {
    display: block;
    color: white;
    text-align: center;
    padding: 10px 16px;
    text-decoration: none;
}

nav ul li a:hover {
    background-color: var(--accent-color);
}
</style>

<style>
</style>
