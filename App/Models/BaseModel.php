<?php
namespace App\Models;

use App\Core\Database;

abstract class BaseModel {
    protected $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    // Common methods for all models
    protected function query($sql, $params = []) {
        $stmt = $this->db->prepare($sql);
        if (!$stmt) {
            throw new \Exception("SQL error: " . $this->db->error);
        }

        if (!empty($params)) {
            $types = str_repeat('s', count($params));
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        return $stmt;
    }
}