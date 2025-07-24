<?php

namespace App\Core;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;


class Mailer
{
    protected $mailer;

    public function __construct()
    {
        $emailConfig = require __DIR__ . '/../../config/email.php';
        $this->mailer = new PHPMailer(true);

        // Use Gmail SMTP server settings.
        $this->mailer->SMTPDebug = SMTP::DEBUG_SERVER;
        $this->mailer->isSMTP();
        $this->mailer->Host       = $emailConfig['host'];
        $this->mailer->SMTPAuth   = true;
        $this->mailer->Username   = $emailConfig['username'];        // Replace with your Gmail address.
        $this->mailer->Password   = $emailConfig['password'];            // Replace with your Gmail app password.
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;   // Use TLS encryption.
        $this->mailer->Port       = $emailConfig['port'];

        // Set a sender. Using the same Gmail account.
        $this->mailer->setFrom($emailConfig['username'], 'Notification from IT Department');
    }

    /**
     * Sends an email.
     *
     * @param string $to      Recipient email address.
     * @param string $subject Email subject.
     * @param string $body    Email body as HTML.
     *
     * @return bool Returns true on success, false on failure.
     */
    public function sendMail(string $to, string $subject, string $body): bool
    {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($to);
            $this->mailer->Subject = $subject;
            $this->mailer->Body    = $body;
            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            error_log('MailService Error: ' . $e->getMessage());
            return false;
        }
    }
}
