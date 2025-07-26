<?php

namespace App\Core;

use App\Controllers\ErrorController;
use PDO;
use PDOException;

class Database
{
    private static $instance = null;
    private PDO $connection;

    private function __construct()
    {
        $config = require __DIR__ . '/../../config/db.php';

        try {
            $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ];
            
            $this->connection = new PDO(
                $dsn,
                $config['username'],
                $config['password'],
                $options
            );
        } catch (PDOException $e) {
            // Handle connection error
            /**
             * Display a user-friendly error message
             * In production, you might want to log this error instead of displaying it.
             * 
             */
            //redirect to a custom error page
            ErrorController::notFound('Database connection failed');

            //Log the error message in json format
            $errorData = [
                'error' => 'Database connection failed',
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ];
            //convert the error data to JSON
            $errorJson = json_encode($errorData, JSON_PRETTY_PRINT);
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
