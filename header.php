<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<div class="top-header">
    <div class="top-header-content">
        <div class="top-header-contact">
            <i class="bi bi-telephone-fill"></i> +1 (555) 123-4567 &nbsp; | &nbsp; 
            <i class="bi bi-envelope-fill"></i> support@pajemobank.com
        </div>
        <form class="search-form" action="search.php" method="GET">
            <input type="text" name="q" placeholder="Search..." aria-label="Search">
            <button type="submit">Search</button>
        </form>
        <select class="language-translator" aria-label="Select Language">
            <option value="en" selected>English</option>
            <option value="es">Spanish</option>
            <option value="fr">French</option>
            <option value="de">German</option>
            <option value="zh">Chinese</option>
        </select>
    </div>
</div>

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
        <?php endif; ?>
    </ul>
</nav>

<?php if (!isset($_SESSION['user_id'])): ?>
<div class="nav-links" style="display: flex; justify-content: space-between; align-items: center; gap: 10px; height: 40px;">
    <div style="flex-shrink: 0;">
        <a href="index.php"><img src="images/logo.png" alt="Pajemo Bank circular logo with a classical bank building in front of mountains and a sunrise, surrounded by the words PAJEMO BANK in large letters, conveying trust and stability" style="height: 25px;"></a>
    </div>
    <div style="display: flex; gap: 10px; align-items: center; justify-content: space-between; width: 100%; height: 30px;">
        <span style="margin-right: 20px;">
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
