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

        $stmt = $this->db->prepare("SELECT id FROM {$this->table} WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    public function getUserByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }


    public function register($name, $email, $password = "", $userType = 'registered')
    {
        // Check if email exists
        if ($this->checkEmailExists($email)) {
            return false;
        }

        // Insert user

        $stmt = $this->db->prepare("INSERT INTO {$this->table} (name, email, password, user_type) VALUES (?, ?, ?,?)");
        $stmt->bind_param("ssss", $name, $email, $password, $userType);

        try {
            $stmt->execute();
            return $stmt;
        } catch (\Exception $e) {
            Session::setFlashMessage('error', 'User Creation Failed');
            redirect('/');
        }
    }
}
