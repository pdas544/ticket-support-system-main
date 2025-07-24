<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';

// 1. Grab the temp‐file path
$tmpFile = $argv[1] ?? '';

if (! is_file($tmpFile) || ! is_readable($tmpFile)) {
    file_put_contents(__DIR__ . '/send_error.log', "Missing or unreadable file: $tmpFile\n", FILE_APPEND);
    exit(1);
}

// 2. Decode JSON
$json = file_get_contents($tmpFile);
$data = json_decode($json, true);

// 3. Clean up immediately to avoid temp buildup
@unlink($tmpFile);

if (! $data) {
    file_put_contents(__DIR__ . '/send_error.log', "Invalid JSON in file: $tmpFile\n", FILE_APPEND);
    exit(1);
}


$name = $data['name'];
$recipientEmail = $data['to'];
$message =  $data['body'];
$subject = $data['subject'];


$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->Username = "itdeskbbsr@gmail.com";
    $mail->Password = "sutb mbjn ghkf fahy";
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom("it.bhubaneswar@nift.ac.in", "IT Support Desk");
    $mail->addAddress($recipientEmail, $name);

    $mail->Subject = $subject;
    $mail->Body = $message;


    $mail->send();
    exit(0);
} catch (Exception $e) {
    file_put_contents(__DIR__ . '/send_error.log', $e->getMessage() . "\n", FILE_APPEND);
    exit(1);
}
