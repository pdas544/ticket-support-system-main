<?php

namespace App\Models;


use App\Core\Security;
use App\Core\Session;
use App\Models\BaseModel;

class User extends BaseModel
{

    protected $table = 'new_users';

    // public function __construct() {
    //     $this->db = Database::getInstance();
    // }
    public function checkEmailExists($email)
    {
        $stmt = $this->query("SELECT id FROM {$this->table} WHERE email = ?", [$email]);
        $result = $this->fetch($stmt);
        return $result !== false;
    }

    public function getUserByEmail($email)
    {
        $stmt = $this->query("SELECT * FROM {$this->table} WHERE email = ?", [$email]);
        return $this->fetch($stmt);
    }


    public function register($name, $email, $password = "", $userType = 'registered')
    {
        // Check if email exists
        if ($this->checkEmailExists($email)) {
            return false;
        }

        // Insert user
        $sql = "INSERT INTO {$this->table} (name, email, password, user_type) VALUES (?, ?, ?, ?)";
        
        try {
            $this->query($sql, [$name, $email, $password, $userType]);
            return $this->lastInsertId();
        } catch (\Exception $e) {
            Session::setFlashMessage('error', 'User Creation Failed');
            redirect('/');
        }
    }
}
