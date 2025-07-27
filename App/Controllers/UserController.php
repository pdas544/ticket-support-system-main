<?php

namespace App\Controllers;


use App\Core\Validation;
use App\Core\Session;
use App\Models\User;
use App\Models\Ticket;
use App\Controllers\ErrorController;

class UserController
{
  private $userModel;
  private $ticketModel;

  public function __construct()
  {
    $this->userModel = new User();
    $this->ticketModel = new Ticket();
  }

  /**
   * Show the login page
   * 
   * @return void
   */
  public function login()
  {
    loadView('auth/login');
  }

  /**
   * Show the register page
   * 
   * @return void
   */
  public function create()
  {
    loadView('users/create');
  }

  /**
   * Store user in database
   * 
   * @return void
   */
  public function store()
  {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordConfirmation = $_POST['password_confirmation'];

    $errors = [];

    // Validation
    if (!Validation::email($email)) {
      $errors['email'] = 'Please enter a valid email address';
    }

    if (!Validation::string($name, 2, 50)) {
      $errors['name'] = 'Please enter a valid name';
    }

    if (!Validation::string($password, 6, 50)) {
      $errors['password'] = 'Password must be at least 6 characters';
    }

    //Email pattern validation ending with .nift.ac.in
    // if (!Validation::matchPattern($email, '/^[a-zA-Z0-9._%+-]+@nift\.ac\.in$/')) {
    //   $errors['email'] = 'Email must end with @nift.ac.in';
    // }

    // Password requirements: At least 6 characters, 1 uppercase letter, 1 lowercase letter, 1 number, and 1 special character
    // if (!Validation::matchPattern($password, '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/')) {
    //   $errors['password'] = 'Password requirement not met.';
    // }

    if (!Validation::match($password, $passwordConfirmation)) {
      $errors['password_confirmation'] = 'Passwords do not match';
    }

    if (!empty($errors)) {
      loadView('users/create', [
        'errors' => $errors,
        'user' => [
          'name' => $name,
          'email' => $email,
        ]
      ]);
      exit;
    }


    $user = $this->userModel->getUserByEmail($email);

    if ($user) {
      $errors['email'] = 'Email already exists. Kindly Login';
      loadView('users/create', [
        'errors' => $errors,
        'user' => [
          'name' => $name
        ]
      ]);
      exit;
    }


    $password = password_hash($password, PASSWORD_DEFAULT);
    $regObject = $this->userModel->register($name, $email, $password, $userType = 'registered');

    //get the id of the newly inserted row
    $userId = $regObject->insert_id;

    Session::setFlashMessage('success', 'Registration Successful.');

    redirect('/');
  }

  /**
   * Logout a user and kill session
   * 
   * @return void
   */
  public function logout()
  {
    Session::clearAll();

    $params = session_get_cookie_params();
    setcookie('PHPSESSID', '', time() - 86400, $params['path'], $params['domain']);


    header('Location: /?logout=true');
    exit;
  }

  /**
   * Authenticate a user with email and password
   * and redirect the user to the dashboard
   * 
   * @return void
   */
  public function authenticate()
  {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $errors = [];

    // Validation
    if (!Validation::email($email)) {
      $errors['email'] = 'Please enter a valid email';
    }

    if (!Validation::string($password, 6, 50)) {
      $errors['password'] = 'Password must be at least 6 characters';
    }

    // Check for errors
    if (!empty($errors)) {
      loadView('auth/login', [
        'errors' => $errors
      ]);
      exit;
    }


    $user = $this->userModel->getUserByEmail($email);

    if (!$user) {
      $errors['email'] = 'Incorrect credentials';
      loadView('auth/login', [
        'errors' => $errors
      ]);
      exit;
    }

    // inspectAndDie($user);

    // Check if password is correct
    if (!password_verify($password, $user['password'])) {
      $errors['email'] = 'Incorrect credentials';
      loadView('auth/login', [
        'errors' => $errors
      ]);
      exit;
    }

    // Set user session
    Session::set('user', [
      'id' => $user['id'],
      'name' => $user['name'],
      'email' => $user['email'],
      'role' => $user['role']
    ]);

    //Set flash message
    Session::setFlashMessage('success', "Login Successful");

    redirect('/dashboard');
  }


  /**
   * Show the dashboard
   * 
   * @return void
   */
  public function showDashboard(): void
  {
    //check if the Session exists
    if (Session::has('user')) {
      $role = Session::get('user')['role'];
      $userId = Session::get('user')['id'];
      switch ($role) {
        case 'admin':
          $stats = [
            'total' => $this->ticketModel->getTotalTickets(),
            'today' => $this->ticketModel->getTicketsRaisedToday(),
            'pending' => $this->ticketModel->getPendingTickets(),
            'resolved' => $this->ticketModel->getResolvedTickets()
          ];
          loadView('/dashboard/admin', ['stats' => $stats, 'role' => $role]);
          break;
        case 'agent':
            $stats = [
                'total' => $this->ticketModel->getTotalTickets(),
                'today' => $this->ticketModel->getTicketsRaisedToday(),
                'pending' => $this->ticketModel->getPendingTickets(),
                'resolved' => $this->ticketModel->getTicketsByAgentId($userId),
            ];
          loadView('/dashboard/agent', ['stats' => $stats, 'role' => $role]);
          break;
        case 'guest':
            $stats = [
                'total_by_user' => $this->ticketModel->getTicketsByUserId($userId),
            ];
          loadView('/dashboard/user', ['stats' => $stats, 'role' => $role]);;
          break;
        default:
          ErrorController::unauthorized();
      }
    } else {
      ErrorController::unauthorized();
    }
  }
}
