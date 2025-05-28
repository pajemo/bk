<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Supported languages - top 15 languages by native speakers approx
$supported_languages = ['en', 'zh', 'hi', 'es', 'fr', 'ar', 'bn', 'ru', 'pt', 'id', 'ur', 'de', 'ja', 'sw', 'mr'];

// Default language
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'en';
}

// Change language if requested
if (isset($_GET['lang']) && in_array($_GET['lang'], $supported_languages)) {
    $_SESSION['lang'] = $_GET['lang'];
}

// Translation strings
$translations = [
    'en' => [
        'welcome' => 'Welcome',
        'register' => 'Register',
        'login' => 'Login',
        'logout' => 'Logout',
        'email' => 'Email',
        'password' => 'Password',
        'deposit' => 'Deposit',
        'withdrawal' => 'Withdrawal',
        'amount' => 'Amount',
        'submit' => 'Submit',
        'dashboard' => 'Dashboard',
        'recent_transactions' => 'Recent Transactions',
        'account_balance' => 'Account Balance',
        'invalid_email' => 'Invalid email format.',
        'password_length' => 'Password must be at least 6 characters.',
        'email_exists' => 'Email already registered.',
        'registration_success' => 'Registration successful! Please check your email to verify your account.',
        'verification_email_failed' => 'Failed to send verification email.',
        'email_verified' => 'Email verified successfully! You can now login.',
        'invalid_verification_code' => 'Invalid verification code.',
        'login_code_sent' => 'Login code sent to your email.',
        'invalid_login_code' => 'Invalid login code.',
        'login_code_expired' => 'This login code has expired.',
        'insufficient_balance' => 'Insufficient balance.',
        'invalid_amount' => 'Invalid amount.',
        'email_not_verified' => 'Email not verified. Please verify your email first.',
        'email_not_registered' => 'Email not registered.',
    ],
    // Add other languages here with translations
    // For brevity, only English is fully defined here
];

// Function to get translation
function t($key) {
    global $translations;
    $lang = $_SESSION['lang'] ?? 'en';
    if (isset($translations[$lang]) && isset($translations[$lang][$key])) {
        return $translations[$lang][$key];
    }
    // Fallback to English
    return $translations['en'][$key] ?? $key;
}
?>
