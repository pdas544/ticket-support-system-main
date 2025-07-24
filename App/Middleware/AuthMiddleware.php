<?php

namespace App\Middleware;

use App\Core\Session;

class AuthMiddleware
{
    protected $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function handle()
    {
        if (!$this->session->has('user')) {
            redirect('/auth/login');
        }
        return true;
    }
}
