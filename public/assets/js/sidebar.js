/**
 * Sidebar functionality using jQuery
 * This script handles active link states and submenu functionality
 */
$(function() {
    // Cache jQuery objects for better performance
    const $sidebar = $('.sidebar');
    const $sidebarLinks = $('.sidebar .nav-link');
    const $submenuToggles = $('.sidebar .nav-link[data-bs-toggle="collapse"]');
    
    // Handle active state for sidebar links
    const currentPath = window.location.pathname;
    
    $sidebarLinks.each(function() {
        const $link = $(this);
        const href = $link.attr('href');
        
        // Mark current page link as active
        if (href && currentPath.includes(href) && href !== '/') {
            $link.addClass('active');
            
            // If link is in a submenu, expand that submenu
            const $parentSubmenu = $link.parents('.sub-menu');
            if ($parentSubmenu.length) {
                $parentSubmenu.addClass('show');
            }
        }
    });
    
    // Clear any localStorage settings from previous implementation
    localStorage.removeItem('sidebarCollapsed');
});