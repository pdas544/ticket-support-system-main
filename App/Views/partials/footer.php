<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="/assets/js/sidebar.js"></script>
<script>
    /**
     * Additional sidebar functionality
     * Handles tooltips for password input
     */
    $(function() {
        // Cache jQuery objects
        const $passwordInput = $('#password');
        
        // Initialize tooltips if password input exists
        $passwordInput.length && $passwordInput.tooltip({
            trigger: 'focus'
        });
    });
</script>
</body>

</html>