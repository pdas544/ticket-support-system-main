<?php

namespace App\Middleware;

use App\Core\Session;

class GuestMiddleware
{
    protected $session;

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

    /**
     * Handle the middleware
     * 
     * Check if user is already logged in and redirect to dashboard
     * 
     * @return bool
     */
    public function handle()
    {
        if ($this->session->has('user')) {
            redirect('/dashboard');
        }
        return true;
    }
}