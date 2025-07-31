<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!--DataTable JS-->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<!--DataTable JS-->
<!-- Export Buttons JS -->
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script>
    $(document).ready(function() {
        $("#ticketsTable").DataTable({
            responsive: true,

            dom: '<"d-flex justify-content-between align-items-center"lfB>rt<"d-flex justify-content-between"ip>',
            buttons: [
                'excel', 'pdf'
            ],

        });

        // Show/hide update icons when checkbox is checked
        $(".update-checkbox").change(function() {
            if($(this).is(":checked")) {
                $(this).closest("tr").find(".update-icon").show();
            } else {
                $(this).closest("tr").find(".update-icon").hide();
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Elements
        const sidebar = document.querySelector('.sidebar');
        const sidebarLinks = document.querySelectorAll('.sidebar .nav-link:not([data-bs-toggle="collapse"])');
        const sidebarToggle = document.querySelector('[data-bs-target=".sidebar"]');
        const passwordInput = document.getElementById('password');
        
        // Initialize tooltips if password input exists
        if (passwordInput) {
            new bootstrap.Tooltip(passwordInput, {
                trigger: 'focus',
            });
        }
        
        // Handle active state for sidebar links
        const currentPath = window.location.pathname;
        sidebarLinks.forEach(link => {
            const href = link.getAttribute('href');
            if (href && currentPath.includes(href) && href !== '/') {
                link.classList.add('active');
            }
            
            // Close sidebar when clicking a link on mobile
            link.addEventListener('click', function() {
                if (window.innerWidth < 992) { // Bootstrap lg breakpoint
                    const bsCollapse = bootstrap.Collapse.getInstance(sidebar);
                    if (bsCollapse) {
                        bsCollapse.hide();
                    }
                }
            });
        });
        
        // Update aria-expanded attribute on toggle button
        if (sidebar && sidebarToggle) {
            sidebar.addEventListener('show.bs.collapse', function() {
                sidebarToggle.setAttribute('aria-expanded', 'true');
                // Add show class for CSS transitions
                sidebar.classList.add('show');
            });
            
            sidebar.addEventListener('hide.bs.collapse', function() {
                sidebarToggle.setAttribute('aria-expanded', 'false');
                // Remove show class for CSS transitions
                sidebar.classList.remove('show');
            });
            
            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 992) { // Bootstrap lg breakpoint
                    // Ensure sidebar is visible on large screens
                    const bsCollapse = bootstrap.Collapse.getInstance(sidebar);
                    if (bsCollapse) {
                        bsCollapse.show();
                    }
                }
            });
        }
    });
</script>
</body>

</html>