<?php

namespace App\Core;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require __DIR__ . '/../../vendor/autoload.php';

// Load the required configuration
$emailConfig = require __DIR__ . '/../../config/email.php';
$errorLogPath = __DIR__ . '/../../logs/error.log';

// 1. Grab the temp‐file path
$tmpFile = $argv[1] ?? '';

if (! is_file($tmpFile) || ! is_readable($tmpFile)) {
    $timestamp = date('Y-m-d H:i:s');
    $errorMessage = "[$timestamp] ERROR: Missing or unreadable file: $tmpFile\n";
    file_put_contents($errorLogPath, $errorMessage, FILE_APPEND);
    exit(1);
}

// 2. Decode JSON
$json = file_get_contents($tmpFile);
$data = json_decode($json, true);


// 3. Clean up immediately to avoid temp buildup
@unlink($tmpFile);

if (! $data) {
    $timestamp = date('Y-m-d H:i:s');
    $errorMessage = "[$timestamp] ERROR: Invalid JSON in file: $tmpFile\n";
    file_put_contents($errorLogPath, $errorMessage, FILE_APPEND);
    exit(1);
}


// Validate required fields in JSON data
$requiredFields = ['to', 'subject', 'body'];
$missingFields = [];

foreach ($requiredFields as $field) {
    if (!isset($data[$field]) || empty($data[$field])) {
        $missingFields[] = $field;
    }
}

if (!empty($missingFields)) {
    $timestamp = date('Y-m-d H:i:s');
    $errorMessage = "[$timestamp] ERROR: Missing required fields in email data: " . implode(', ', $missingFields) . "\n";
    file_put_contents($errorLogPath, $errorMessage, FILE_APPEND);
    exit(1);
}

// Extract data with defaults for optional fields
$name = $data['name'] ?? '';
$recipientEmail = $data['to'];
$message = $data['body'];
$subject = $data['subject'];


$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = $emailConfig['host'];
    $mail->SMTPAuth = true;
    $mail->Username = $emailConfig['username'];
    $mail->Password = $emailConfig['password'];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = $emailConfig['port'];
    
    // Log connection attempt
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[$timestamp] INFO: Attempting to connect to SMTP server: {$emailConfig['host']}:{$emailConfig['port']}\n";
    file_put_contents($errorLogPath, $logMessage, FILE_APPEND);

    $mail->setFrom("it.bhubaneswar@nift.ac.in", "IT Support Desk");
    $mail->addAddress($recipientEmail, $name);

    $mail->Subject = $subject;
    $mail->Body = $message;


    $mail->send();
    
    // Log successful email sending
    $timestamp = date('Y-m-d H:i:s');
    $successMessage = "[$timestamp] INFO: Email sent successfully to: $recipientEmail\n";
    file_put_contents($errorLogPath, $successMessage, FILE_APPEND);
    
    exit(0);
} catch (Exception $e) {
    $timestamp = date('Y-m-d H:i:s');
    $errorContext = [
        'recipient' => $recipientEmail ?? 'unknown',
        'subject' => $subject ?? 'unknown',
        'smtp_server' => $emailConfig['host'] ?? 'unknown',
        'smtp_port' => $emailConfig['port'] ?? 'unknown',
        'smtp_user' => $emailConfig['username'] ?? 'unknown',
        'error_code' => $mail->ErrorInfo ? $mail->ErrorInfo : 'unknown',
        'error_message' => $e->getMessage(),
        'error_trace' => array_slice(explode("\n", $e->getTraceAsString()), 0, 3)
    ];
    $errorMessage = "[$timestamp] ERROR: Failed to send email: " . json_encode($errorContext, JSON_PRETTY_PRINT) . "\n";
    file_put_contents($errorLogPath, $errorMessage, FILE_APPEND);
    
    // Also log to PHP error log for system-level visibility
    error_log("Email sending failed: " . $e->getMessage());
    
    exit(1);
}
