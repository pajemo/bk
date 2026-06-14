<?php
// mailer.php - Handles all email sending using PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load PHPMailer (must be installed via Composer: composer require phpmailer/phpmailer)
require_once __DIR__ . '/vendor/autoload.php';

function parseBoolEnv($key, $default = true) {
    $value = getenv($key);
    if ($value === false || $value === '') {
        return $default;
    }

    $normalized = strtolower(trim($value));
    return in_array($normalized, ['1', 'true', 'yes', 'on'], true);
}

function resolveEncryptionMode($mode) {
    $normalized = strtolower(trim((string)$mode));
    if ($normalized === 'tls' || $normalized === 'starttls') {
        return PHPMailer::ENCRYPTION_STARTTLS;
    }
    if ($normalized === 'none' || $normalized === '') {
        return false;
    }
    return PHPMailer::ENCRYPTION_SMTPS;
}

/**
 * sendEmail()
 * Send a simple HTML email to any recipient.
 *
 * @param string $to Recipient email address
 * @param string $subject Subject of the email
 * @param string $body HTML content for the email
 * @param string $altBody Plain text fallback (optional)
 * @return bool Returns true if sent successfully, false otherwise
 */
function sendEmail($to, $subject, $body, $altBody = '') {
    $mail = new PHPMailer(true);

    $smtpHost = getenv('SMTP_HOST') ?: 'smtp.gmail.com';
    $smtpPort = (int)(getenv('SMTP_PORT') ?: 465);
    $smtpAuth = parseBoolEnv('SMTP_AUTH', true);
    $smtpUser = getenv('SMTP_USERNAME') ?: '';
    $smtpPass = getenv('SMTP_PASSWORD') ?: '';
    $smtpSecure = resolveEncryptionMode(getenv('SMTP_SECURE') ?: 'ssl');
    $fromEmail = getenv('SMTP_FROM_EMAIL') ?: $smtpUser;
    $fromName = getenv('SMTP_FROM_NAME') ?: 'EinlageCapital';
    $replyToEmail = getenv('SMTP_REPLY_TO_EMAIL') ?: $fromEmail;
    $replyToName = getenv('SMTP_REPLY_TO_NAME') ?: $fromName;

    if ($smtpAuth && ($smtpUser === '' || $smtpPass === '')) {
        error_log('Email sending skipped: SMTP credentials are not configured.');
        return false;
    }

    if ($fromEmail === '') {
        error_log('Email sending skipped: SMTP_FROM_EMAIL is not configured.');
        return false;
    }

    try {
        // SMTP server settings
        $mail->isSMTP();
        $mail->Host = $smtpHost;
        $mail->SMTPAuth = $smtpAuth;
        if ($smtpAuth) {
            $mail->Username = $smtpUser;
            $mail->Password = $smtpPass;
        }
        if ($smtpSecure !== false) {
            $mail->SMTPSecure = $smtpSecure;
        }
        $mail->Port = $smtpPort;

        // Recipients
        $mail->setFrom($fromEmail, $fromName);
        $mail->addReplyTo($replyToEmail, $replyToName);
        $mail->addAddress($to);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->AltBody = $altBody ?: strip_tags($body);

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Email failed to $to: {$mail->ErrorInfo}");
        // Uncomment this line during testing to see errors in browser:
        // echo "Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
}

/**
 * sendStatusEmail()
 * Specialized helper for transfer/loan updates to users.
 */
function sendStatusEmail($email, $name, $reference, $status, $extraDetails = '') {
    $subject = "Update on your transaction – EinlageCapital";
    $body = "
        <p>Hello <strong>{$name}</strong>,</p>
        <p>Your transaction <strong>#{$reference}</strong> is now marked as <strong>{$status}</strong>.</p>
        " . ($extraDetails ? "<p><em>Details:</em> {$extraDetails}</p>" : "") . "
        <p>Thank you for banking with EinlageCapital.</p>
    ";
    return sendEmail($email, $subject, $body);
}
