<?php
// src/Mailer.php

class Mailer
{
    private string $phpBin;
    private string $script;

    public function __construct(string $phpBin, string $script)
    {
        $this->phpBin  = $phpBin;
        $this->script  = $script;
    }

    public function sendAsync(string $to, string $subject, string $body, string $name = ''): void
    {
        // 1. Prepare payload
        $payload = json_encode([
            'to'      => $to,
            'name'    => $name,
            'subject' => $subject,
            'body'    => $body,
        ]);

        // 2. Temp file
        $tmpDir  = sys_get_temp_dir();
        $tmpFile = $tmpDir . DIRECTORY_SEPARATOR . 'mail_' . uniqid() . '.json';
        file_put_contents($tmpFile, $payload);

        // 3. Build Windows start command
        //    - "" is a dummy window title
        //    - Wrap paths in quotes to handle spaces
        $cmd = sprintf(
            'start /B "" "%s" "%s" "%s"',
            $this->phpBin,
            $this->script,
            $tmpFile
        );


        pclose(popen($cmd, 'r'));
    }
}
