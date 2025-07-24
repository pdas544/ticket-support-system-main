<?php
namespace App\Controllers;

use App\Models\User;
use App\Core\View;
use App\Core\Session;
use App\Core\Security;

class AuthController {
    protected $view;
    protected $userModel;

    public function __construct() {
        
    }

    public function showRegistrationForm() {
        
        
    }

    public function handleRegistration() {
        // Validate CSRF token
        if (!Security::verifyCsrfToken($_POST['csrf_token'])) {
            Session::flash('error', 'Invalid CSRF token');
            header('Location: /register');
            exit;
        }

        // Validate inputs
        $name = trim($_POST['name']);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirm_password'];

        if (!$this->validateInputs($name, $email, $password, $confirmPassword)) {
            header('Location: /register');
            exit;
        }

        if ($this->userModel->register($name, $email, $password)) {
            Session::flash('success', 'Registration successful!');
            header('Location: /register');
        } else {
            
            Session::flash('error', 'Registration failed. Email already exists.');
            header('Location: /register');
        }
        exit;
    }

    private function validateInputs($name, $email, $password, $confirmPassword) {
        $errors = [];
        $valid = true;
    
        // Name validation
        if (empty(trim($name))) {
            $errors['name'] = 'Name is required.';
            $valid = false;
        } elseif (!preg_match('/^([a-zA-Z\s]{5,})$/', $name)) {
            $errors['name'] = 'Name must be 2-10 characters with only letters and spaces.';
            $valid = false;
        }
    
        // Email validation
        if (empty(trim($email))) {
            $errors['email'] = 'Email is required.';
            $valid = false;
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email format.';
            $valid = false;
        } elseif (!preg_match('/@nift\.ac\.in$/i', $email)) {
            $errors['email'] = 'Must use official NIFT email address (@nift.ac.in).';
            $valid = false;
        }
    
        // Password validation
        if (empty(trim($password))) {
            $errors['password'] = 'Password is required.';
            $valid = false;
        } else {
            if (strlen($password) < 5) {
                $errors['password'] = 'Password must be at least 5 characters.';
                $valid = false;
            }
            if (!preg_match('/[A-Z]/', $password)) {
                $errors['password'] = 'Requires at least one uppercase letter.';
                $valid = false;
            }
            if (!preg_match('/[a-z]/', $password)) {
                $errors['password'] = 'Requires at least one lowercase letter.';
                $valid = false;
            }
            if (!preg_match('/\d/', $password)) {
                $errors['password'] = 'Requires at least one number.';
                $valid = false;
            }
            if (!preg_match('/[^A-Za-z0-9]/', $password)) {
                $errors['password'] = 'Requires at least one special character.';
                $valid = false;
            }
        }
    
        // Confirm password validation
        if (empty(trim($confirmPassword))) {
            $errors['confirm_password'] = 'Please confirm your password.';
            $valid = false;
        } elseif ($password !== $confirmPassword) {
            $errors['confirm_password'] = 'Passwords do not match.';
            $valid = false;
        }
    
        if (!$valid) {
            Session::flash('errors', $errors);
            Session::flash('old', [
                'name' => htmlspecialchars($name),
                'email' => htmlspecialchars($email)
            ]);
        }
    
        return $valid;
    }
}