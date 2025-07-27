<?php

namespace App\Models;


use App\Core\Security;
use App\Core\Session;
use App\Models\BaseModel;
use PDO;

class User extends BaseModel
{

    protected $table = 'new_users';

    // public function __construct() {
    //     $this->db = Database::getInstance();
    // }
//    public function checkEmailExists($email)
//    {
//        $stmt = $this->query("SELECT id FROM {$this->table} WHERE email = ?", [$email]);
//        $result = $this->fetch($stmt);
//        return $result !== false;
//    }

    public function getUserByEmail($email)
    {
        $params = [
            'email' => [$email,PDO::PARAM_STR],
        ];
        $stmt = $this->query("SELECT * FROM {$this->table} WHERE email = :email", $params);
        return $this->fetch($stmt);
    }


    public function register($name, $email, $password = "", $userType = 'registered')
    {
        // Check if email exists
        if ($this->getUserByEmail($email)) {
            return false;
        }



        // Insert user
        $params = [
          'name'=> [$name,PDO::PARAM_STR],
          'email'=> [$email,PDO::PARAM_STR],
          'password'=> [$password,PDO::PARAM_STR],
          'user_type'=> [$userType,PDO::PARAM_STR],
        ];
        $sql = "INSERT INTO {$this->table} (name, email, password, user_type) VALUES (:name, :email, :password, :user_type)";
        
        try {
            $this->query($sql, $params);
            return $this->lastInsertId();
        } catch (\Exception $e) {
            Session::setFlashMessage('error', 'User Creation Failed');
            redirect('/');
        }
    }
}
