<?php

namespace App\Controllers;


class NotificationController
{

    private string $phpBin = 'php.exe';
    private string $script = __DIR__ . '/../Core/SendMail.php';

    private string $errorLogPath = __DIR__ . '/../../logs/error.log';

    public function __construct()
    {
        //$this->mailer = new Mailer($this->phpBin, $this->script);
    }
    /**
     * Send an email asynchronously in the background
     * 
     * @param string $to Recipient email address
     * @param string $subject Email subject
     * @param string $body Email body content
     * @param string $name Optional recipient name
     * @return bool True if the background process was started successfully, false otherwise
     */
    public function send($to, $subject, $body, $name = '')
    {
        try {
            // 1. Prepare payload
            $payload = json_encode([
                'to'      => $to,
                'name'    => $name,
                'subject' => $subject,
                'body'    => $body,
            ]);
            
            if (!$payload) {
                $this->logError("Failed to encode email data as JSON", [
                    'to' => $to,
                    'subject' => $subject
                ]);
                return false;
            }

            // 2. Temp file
            $tmpDir = sys_get_temp_dir();
            $tmpFile = $tmpDir . DIRECTORY_SEPARATOR . 'mail_' . uniqid() . '.json';
            
            if (file_put_contents($tmpFile, $payload) === false) {
                $this->logError("Failed to write email data to temporary file", [
                    'tmpFile' => $tmpFile,
                    'to' => $to,
                    'subject' => $subject
                ]);
                return false;
            }

            // 3. Build Windows start command
            //    - "" is a dummy window title
            //    - Wrap paths in quotes to handle spaces
            $cmd = sprintf(
                'start /B "" "%s" "%s" "%s"',
                $this->phpBin,
                $this->script,
                $tmpFile
            );

            // Log the command being executed (without sensitive data)
            $this->logInfo("Starting background email process", [
                'to' => $to,
                'subject' => $subject,
                'script' => $this->script
            ]);


            // Execute the command
            $handle = popen($cmd, 'r');
            if (!$handle) {
                $this->logError("Failed to start background email process", [
                    'to' => $to,
                    'subject' => $subject
                ]);
                @unlink($tmpFile); // Clean up temp file
                return false;
            }
            
            pclose($handle);
            return true;
            
        } catch (\Exception $e) {
            $this->logError("Exception in send method: " . $e->getMessage(), [
                'to' => $to,
                'subject' => $subject,
                'exception' => get_class($e)
            ]);
            return false;
        }
    }
    
    /**
     * Log an error message to the error log
     * 
     * @param string $message Error message
     * @param array $context Additional context information
     */
    private function logError($message, array $context = [])
    {
        $timestamp = date('Y-m-d H:i:s');
        $errorMessage = "[$timestamp] ERROR: $message: " . json_encode($context) . "\n";
        file_put_contents(__DIR__ . $this->errorLogPath, $errorMessage, FILE_APPEND);
    }
    
    /**
     * Log an informational message to the error log
     * 
     * @param string $message Informational message
     * @param array $context Additional context information
     */
    private function logInfo($message, array $context = [])
    {
        $timestamp = date('Y-m-d H:i:s');
        $infoMessage = "[$timestamp] INFO: $message: " . json_encode($context) . "\n";
        file_put_contents(__DIR__ . $this->errorLogPath, $infoMessage, FILE_APPEND);
    }
}
