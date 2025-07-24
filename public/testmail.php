<?php

require __DIR__ . '/Mailer.php';

$binPath = 'php.exe';
$script =  __DIR__ . '/sendmail.php';

// die(php_uname());


$mailer = new Mailer($binPath, $script);

// Dispatch in background immediately
$mailer->sendAsync(
    'priyabrata.das@nift.ac.in',
    'Welcome to Our Site',
    'Thanks for signing up!',
    'New User'
);

header('Content-Type: application/json');
echo json_encode(['status' => 'Email queued for background sending.']);
exit;
