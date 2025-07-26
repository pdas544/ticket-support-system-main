<!-- Sidebar -->
<!-- Sidebar Toggle Button (visible on mobile) -->
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
                   data-bs-toggle="collapse" data-bs-target="#submenu" 
                   aria-expanded="false" aria-controls="submenu">

                        <span class="icon me-3">
                            <i class="bi bi-clipboard-check"></i>
                        </span>
                        <span class="description">Tickets</span>

                    <span class="ms-auto">
                        <i class="bi bi-caret-down-fill"></i>
                    </span>
                </a>
                
                <!-- Tickets Submenu -->
                <div class="sub-menu collapse" id="submenu">
                    <a href="/tickets" class="nav-link d-flex align-items-center ps-4">
                        <span class="icon me-3">
                            <i class="bi bi-file-earmark-check"></i>
                        </span>
                        <span class="description">View All Tickets</span>
                    </a>
                    <a href="/tickets/modify" class="nav-link d-flex align-items-center ps-4">
                        <span class="icon me-3">
                            <i class="bi bi-pencil-square"></i>
                        </span>
                        <span class="description">Modify Tickets</span>
                    </a>
                </div>
            </nav>
        </div>
    </div>