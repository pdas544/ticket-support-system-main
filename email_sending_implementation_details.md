# Email Sending Implementation Details

This document provides specific code changes to implement the recommendations in `email_sending_recommendations.md`.

## 1. Dependency Injection in TicketController

```php
// In TicketController.php
class TicketController
{
    private $ticketModel;
    private $userModel;
    private $notificationController;

    public function __construct()
    {
        $this->ticketModel = new Ticket();
        $this->userModel = new User();
        $this->notificationController = new NotificationController(); // Initialize here
    }

    // Remove initialization from store() method
    public function store()
    {
        // ... existing code ...
        
        // Use the already initialized controller
        $this->notificationController->send(
            $email,
            "Ticket Created Successfully with Ticket ID {$ticketId}",
            // ... rest of the parameters ...
        );
    }
}
```

## 2. Use the Mailer Class in NotificationController

```php
// In NotificationController.php
use App\Core\Mailer;

class NotificationController
{
    private Mailer $mailer;
    private string $phpBin = 'php.exe';
    private string $script = __DIR__ . '/../Core/SendMail.php';

    public function __construct()
    {
        $this->mailer = new Mailer($this->phpBin, $this->script);
    }
    
    public function send($to, $subject, $body, $name = '')
    {
        // Use the Mailer class instead of duplicating code
        $this->mailer->sendAsync($to, $subject, $body, $name);
    }
}
```

## 3. Use Configuration File in SendMail.php

```php
// In App\Core\SendMail.php
// Replace hardcoded credentials with config
$emailConfig = require __DIR__ . '/../../config/email.php';

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = $emailConfig['host'];
    $mail->SMTPAuth = true;
    $mail->Username = $emailConfig['username'];
    $mail->Password = $emailConfig['password'];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = $emailConfig['port'];
    
    // ... rest of the code ...
}
```

## 4. Cross-Platform Compatibility

```php
// In App\Core\Mailer.php
public function sendAsync(string $to, string $subject, string $body, string $name = ''): void
{
    // ... existing payload and temp file code ...
    
    // Platform-agnostic approach using proc_open
    $descriptorspec = [
        0 => ["pipe", "r"],  // stdin
        1 => ["pipe", "w"],  // stdout
        2 => ["pipe", "w"],  // stderr
    ];
    
    $command = sprintf('"%s" "%s" "%s"', $this->phpBin, $this->script, $tmpFile);
    
    // Start the process in background
    $process = proc_open($command, $descriptorspec, $pipes, null, null, ['bypass_shell' => true]);
    
    // Close pipes and process handle
    foreach ($pipes as $pipe) {
        fclose($pipe);
    }
    proc_close($process);
}
```

## 5. Consistent Error Handling

```php
// Create a dedicated error logging function in a helper file
function logError($message, $context = [])
{
    $timestamp = date('Y-m-d H:i:s');
    $contextStr = !empty($context) ? json_encode($context) : '';
    $logMessage = "[$timestamp] ERROR: $message $contextStr\n";
    file_put_contents(__DIR__ . '/../../logs/error.log', $logMessage, FILE_APPEND);
}

// Then in SendMail.php
try {
    // ... mail sending code ...
} catch (Exception $e) {
    logError('Failed to send email', [
        'error' => $e->getMessage(),
        'recipient' => $recipientEmail,
        'subject' => $subject
    ]);
    exit(1);
}
```

## 6. Type Declarations

```php
// In NotificationController.php
public function send(string $to, string $subject, string $body, string $name = ''): void
{
    // ... method body ...
}

// In TicketController.php
public function store(): void
{
    // ... method body ...
}
```

## 7. Queue System Consideration

For a more robust solution, consider implementing a proper queue system:

1. Install a queue library via Composer (e.g., php-enqueue/fs)
2. Create a dedicated QueueService class
3. Send emails through the queue instead of direct background processing

This would require more significant changes but would greatly improve reliability and scalability.