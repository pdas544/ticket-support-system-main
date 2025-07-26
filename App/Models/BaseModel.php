<?php
namespace App\Models;

use App\Core\Database;
use PDO;
use PDOException;

abstract class BaseModel {
    protected $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    // Common methods for all models
    protected function query($sql, $params = []) {
        try {
            $stmt = $this->db->prepare($sql);
            
            if (!empty($params)) {
                foreach ($params as $key => $value) {
                    // PDO uses 1-based indexing for positional parameters
                    $paramIndex = is_numeric($key) ? $key + 1 : $key;
                    $stmt->bindValue($paramIndex, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
                }
            }
            
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new \Exception("SQL error: " . $e->getMessage());
        }
    }
    
    // Helper method to fetch all results as associative array
    protected function fetchAll($stmt) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Helper method to fetch a single row as associative array
    protected function fetch($stmt) {
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Helper method to get last inserted ID
    protected function lastInsertId() {
        return $this->db->lastInsertId();
    }
}