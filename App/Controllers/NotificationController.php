<?php

namespace App\Controllers;

use App\Core\Mailer;

class NotificationController
{
    private $mailer;
    private $phpBin = 'php.exe';
    private $script = __DIR__ . '/../Core/SendMail.php';

    public function __construct()
    {
        $this->mailer = new Mailer($this->phpBin, $this->script);
    }
    public function send($to, $subject, $body, $name = '')
    {
        $response = $this->mailer->sendAsync($to, $subject, $body, $name);

        return $response;
    }
}
