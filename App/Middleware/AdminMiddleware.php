<?php

namespace App\Middleware;

use App\Controllers\ErrorController;
use App\Core\Session;

class AdminMiddleware
{
    protected $session;

    //Dependecy Injection
    /**
     * Constructor
     * 
     * Injecting the Session class for better debugging
     *
     * @param Session $session
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function handle()
    {
        $user = $this->session->get('user');
        // inspectAndDie($user);
        if (!$user || $user['role'] !== 'admin') {
            ErrorController::unauthorized();
            exit;
        }
        return true;
    }
}
