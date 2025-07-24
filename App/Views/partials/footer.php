<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.querySelector('.sidebar');
        const sidebarLinks = document.querySelectorAll('.sidebar .nav-link');
        const sidebarToggle = document.querySelector('[data-bs-target=".sidebar"]');
        const passwordInput = document.getElementById('password');


        if (passwordInput) {
            new bootstrap.Tooltip(passwordInput, {
                trigger: 'focus',
            });
        }



        // Close sidebar when clicking a link on mobile
        sidebarLinks.forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth < 768) {
                    const bsCollapse = new bootstrap.Collapse(sidebar);
                    bsCollapse.hide();
                }
            });
        });

        // Update aria-expanded attribute on toggle button
        sidebar.addEventListener('show.bs.collapse', function() {
            sidebarToggle.setAttribute('aria-expanded', 'true');
        });

        sidebar.addEventListener('hide.bs.collapse', function() {
            sidebarToggle.setAttribute('aria-expanded', 'false');
        });


    });
</script>
</body>

</html>