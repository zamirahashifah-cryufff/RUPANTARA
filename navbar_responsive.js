/**
 * RUPANTARA - Global Responsive Navigation & Mobile Menu Controller
 */
(function() {
    'use strict';

    function initMobileMenu() {
        const overlay = document.getElementById('mobileMenuOverlay');
        const drawer = document.getElementById('mobileMenuDrawer');
        const hamburgerBtn = document.getElementById('hamburgerBtn');
        const closeBtn = document.getElementById('closeDrawerBtn');

        if (!overlay || !drawer) return;

        window.openMobileMenu = function() {
            drawer.classList.add('active');
            overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
            if (window.lucide) {
                window.lucide.createIcons();
            }
        };

        window.closeMobileMenu = function() {
            drawer.classList.remove('active');
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        };

        window.toggleMobileMenu = function() {
            if (drawer.classList.contains('active')) {
                window.closeMobileMenu();
            } else {
                window.openMobileMenu();
            }
        };

        if (hamburgerBtn) {
            hamburgerBtn.addEventListener('click', function(e) {
                e.preventDefault();
                window.toggleMobileMenu();
            });
        }

        if (closeBtn) {
            closeBtn.addEventListener('click', function(e) {
                e.preventDefault();
                window.closeMobileMenu();
            });
        }

        overlay.addEventListener('click', function() {
            window.closeMobileMenu();
        });

        // Close on ESC key press
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && drawer.classList.contains('active')) {
                window.closeMobileMenu();
            }
        });

        // Auto close if window is resized to Desktop view (> 900px)
        window.addEventListener('resize', function() {
            if (window.innerWidth > 900 && drawer.classList.contains('active')) {
                window.closeMobileMenu();
            }
        });

        // Auto close when any navigation link inside drawer is clicked
        const navLinks = drawer.querySelectorAll('.mobile-nav-item a');
        navLinks.forEach(function(link) {
            link.addEventListener('click', function() {
                window.closeMobileMenu();
            });
        });
    }

    // Initialize on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initMobileMenu);
    } else {
        initMobileMenu();
    }
})();
