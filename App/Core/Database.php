<?php

namespace App\Core;

use mysqli;
use mysqli_sql_exception;

class Database
{
    private static $instance = null;
    private $connection;

    private function __construct()
    {

        $config = require __DIR__ . '/../../config/db.php';

        try {
            $this->connection = new mysqli(
                $config['host'],
                $config['username'],
                $config['password'],
                $config['dbname']
            );
        } catch (mysqli_sql_exception $e) {
            // Handle connection error
            /**
             * Display a user-friendly error message
             * In production, you might want to log this error instead of displaying it.
             * 
             */
            //redirect to a custom error page

            //Log the error message in json format
            $errorData = [
                'error' => 'Database connection failed',
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ];
            //convert the error data to JSON
            $errorJson = json_encode($errorData, JSON_PRETTY_PRINT);
            // Ensure the logs directory exists
            /*if (!is_dir(__DIR__ . '/../logs')) {
                mkdir(__DIR__ . '/../logs', 0755, true);
            }*/
            // Log the error message to a file

            error_log("\n" . $errorJson, 3, __DIR__ . '/../../logs/error.log');
            exit;
        }
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance->connection;
    }

    // Prevent cloning and serialization
    private function __clone() {}
    public function __wakeup() {}
}
