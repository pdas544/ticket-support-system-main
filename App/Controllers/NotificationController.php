<?php

namespace App\Controllers;

use App\Core\Mailer;

class NotificationController
{
    private $notification;

    public function __construct()
    {
        $this->notification = new Mailer();
    }
    public function send()
    {
        $response = $this->notification->sendMail('priyabrata.das@nift.ac.in', 'Test Subject', 'This is a test email');

        return $response;
    }
}
