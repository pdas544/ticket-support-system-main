<!-- Sidebar -->
<!-- Sidebar Toggle Button (visible on mobile) -->
<?php use App\Core\Session; ?>
<button class="btn btn-primary d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target=".sidebar" 
        aria-controls="sidebar" aria-expanded="false" aria-label="Toggle sidebar">
    <i class="bi bi-list"></i>
</button>

<!-- Sidebar -->
<div class="sidebar collapse d-lg-block">
        <div class="position-sticky">
            <nav class="nav flex-column">
                <a href="/dashboard" class="nav-link d-flex align-items-center">
                    <span class="icon me-3">
                        <i class="bi bi-grid"></i>
                    </span>
                    <span class="description">Dashboard</span>
                </a>
                
                <!-- Collapsible Tickets Menu -->
                <a href="#" class="nav-link d-flex align-items-center justify-content-between" 
                   data-bs-toggle="collapse" data-bs-target="#ticket-submenu"
                   aria-expanded="false" aria-controls="submenu">

                        <span class="icon me-3">
                            <i class="bi bi-clipboard-check"></i>
                        </span>
                        <span class="description">Tickets</span>

                    <span class="ms-auto">
                        <i class="bi bi-caret-down-fill"></i>
                    </span>
                </a>
                <?php if (Session::has('user')):  ?>
                    <?php if (isset(Session::get('user')['role']) && Session::get('user')['role'] === 'admin'): ?>
                <!-- Tickets Submenu -->
                <div class="sub-menu collapse" id="ticket-submenu">

                    <a href="/tickets" class="nav-link d-flex align-items-center ps-4">
                        <span class="icon me-3">
                            <i class="bi bi-file-earmark-check"></i>
                        </span>
                        <span class="description">View All Tickets</span>
                    </a>
                    <a href="/tickets/report" class="nav-link d-flex align-items-center ps-4">
                        <span class="icon me-3">
                            <i class="bi bi-pencil-square"></i>
                        </span>
                        <span class="description">View Report</span>
                    </a>
                </div>

                <!-- User Menu-->
                <a href="#" class="nav-link d-flex align-items-center justify-content-between"
                   data-bs-toggle="collapse" data-bs-target="#user-submenu"
                   aria-expanded="false" aria-controls="submenu">

                        <span class="icon me-3">
                            <i class="bi bi-clipboard-check"></i>
                        </span>
                    <span class="description">Users</span>

                    <span class="ms-auto">
                        <i class="bi bi-caret-down-fill"></i>
                    </span>
                </a>

                <!-- User Submenu -->
                <div class="sub-menu collapse" id="user-submenu">
                    <a href="/users" class="nav-link d-flex align-items-center ps-4">
                        <span class="icon me-3">
                            <i class="bi bi-file-earmark-check"></i>
                        </span>
                        <span class="description">View All Users</span>
                    </a>

                </div>
                <?php endif; ?>

                <?php if (isset(Session::get('user')['role']) && Session::get('user')['role'] === 'agent'): ?>
                    <div class="sub-menu collapse" id="ticket-submenu">


                        <a href="/tickets" class="nav-link d-flex align-items-center ps-4">
                        <span class="icon me-3">
                            <i class="bi bi-file-earmark-check"></i>
                        </span>
                            <span class="description">View All Tickets</span>
                        </a>

                    </div>
                <?php endif; ?>

                <?php if (isset(Session::get('user')['role']) && Session::get('user')['role'] === 'guest'): ?>
                <div class="sub-menu collapse" id="ticket-submenu">


                    <a href="/tickets" class="nav-link d-flex align-items-center ps-4">
                        <span class="icon me-3">
                            <i class="bi bi-file-earmark-check"></i>
                        </span>
                        <span class="description">View My Tickets</span>
                    </a>

                </div>
                        <a href="#" class="nav-link d-flex align-items-center justify-content-between"
                           data-bs-toggle="collapse" data-bs-target="#profile-submenu"
                           aria-expanded="false" aria-controls="submenu">

                        <span class="icon me-3">
                            <i class="bi bi-clipboard-check"></i>
                        </span>
                            <span class="description">Profile</span>

                            <span class="ms-auto">
                        <i class="bi bi-caret-down-fill"></i>
                    </span>
                        </a>
                        <div class="sub-menu collapse" id="profile-submenu">


                            <a href="/user/edit" class="nav-link d-flex align-items-center ps-4">
                        <span class="icon me-3">
                            <i class="bi bi-file-earmark-check"></i>
                        </span>
                                <span class="description">Change Password</span>
                            </a>

                        </div>

                <?php endif; ?>
                <?php endif;?>
            </nav>
        </div>
    </div>