/**
 * RUPANTARA - Global Responsive Navigation & Mobile Menu Controller
 */
(function() {
    'use strict';

    function initMobileMenu() {
        const nav = document.querySelector('nav');
        if (!nav) return;

        let hamburgerBtn = document.getElementById('hamburgerBtn');
        if (!hamburgerBtn) {
            hamburgerBtn = document.createElement('button');
            hamburgerBtn.id = 'hamburgerBtn';
            hamburgerBtn.className = 'hamburger-btn';
            hamburgerBtn.type = 'button';
            hamburgerBtn.setAttribute('aria-label', 'Buka menu navigasi');
            hamburgerBtn.setAttribute('aria-expanded', 'false');
            hamburgerBtn.innerHTML = '<i data-lucide="menu"></i>';
            const actions = nav.querySelector('.nav-actions');
            (actions || nav).appendChild(hamburgerBtn);
        }

        let overlay = document.getElementById('mobileMenuOverlay');
        let drawer = document.getElementById('mobileMenuDrawer');
        if (!overlay) {
            overlay = document.createElement('div');
            overlay.id = 'mobileMenuOverlay';
            overlay.className = 'mobile-menu-overlay';
            overlay.setAttribute('aria-hidden', 'true');
            document.body.appendChild(overlay);
        }
        if (!drawer) {
            drawer = document.createElement('aside');
            drawer.id = 'mobileMenuDrawer';
            drawer.className = 'mobile-menu-drawer';
            drawer.setAttribute('aria-label', 'Menu navigasi mobile');
            const navLinks = nav.querySelector('.nav-links');
            const profileLink = nav.querySelector('.user-area');
            const links = navLinks ? Array.from(navLinks.querySelectorAll('a')) : [];
            if (profileLink) links.push(profileLink);
            drawer.innerHTML = '<div class="mobile-drawer-header"><strong>Menu RUPANTARA</strong><button type="button" class="mobile-menu-close" id="closeDrawerBtn" aria-label="Tutup menu">&times;</button></div><ul class="mobile-nav-list"></ul>';
            const list = drawer.querySelector('.mobile-nav-list');
            links.forEach(function(link) {
                const item = document.createElement('li');
                item.className = 'mobile-nav-item';
                const copy = link.cloneNode(true);
                copy.className = link.classList.contains('active') ? 'active' : '';
                item.appendChild(copy);
                list.appendChild(item);
            });
            document.body.appendChild(drawer);
        }

        const closeBtn = document.getElementById('closeDrawerBtn');

        window.openMobileMenu = function() {
            drawer.classList.add('active');
            overlay.classList.add('active');
            hamburgerBtn.setAttribute('aria-expanded', 'true');
            document.body.style.overflow = 'hidden';
            if (window.lucide) {
                window.lucide.createIcons();
            }
        };

        window.closeMobileMenu = function() {
            drawer.classList.remove('active');
            overlay.classList.remove('active');
            hamburgerBtn.setAttribute('aria-expanded', 'false');
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
