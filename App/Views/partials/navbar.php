<!-- Navigation Bar -->
<?php
/**
 * 1) Use Session to check if user is logged in
 * 2) If logged in, show user name in navbar
 * 3) If not logged in, show "Sign In" and "Register" links
 * 
 */

use App\Core\Session;
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light px-2">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Ticketing Support</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <?php if (Session::has('user')):  ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/dashboard">
                            Welcome, <?= Session::get('user')['name'] ?>
                        </a>
                    </li>
                    <?php if (isset(Session::get('user')['role']) && Session::get('user')['role'] === 'admin'): ?>
                        <!-- Admin Drop Down menu -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Ticket
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="/admin/tickets/create">Raise Ticket</a></li>
                                <li><a class="dropdown-item" href="/tickets">View All Tickets</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Users
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="/users">View Users</a></li>

                            </ul>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/auth/logout">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Guest
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="/tickets/create">Raise Ticket</a></li>
                            <li><a class="dropdown-item" href="/tickets/check-status">View Ticket Status</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/auth/login">Sign In</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/register">Register</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>