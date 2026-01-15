// Sidebar Component JavaScript

(function () {
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('sidebar');
    const sidebarClose = document.getElementById('sidebarClose');
    const mainContent = document.querySelector('.main-content');

    function toggleSidebar() {
        sidebar.classList.toggle('open');
        if (mainContent) {
            mainContent.classList.toggle('sidebar-open');
        }
        document.body.classList.toggle('sidebar-active');
    }

    if (menuToggle) {
        menuToggle.addEventListener('click', toggleSidebar);
    }

    if (sidebarClose) {
        sidebarClose.addEventListener('click', toggleSidebar);
    }

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', (e) => {
        if (window.innerWidth <= 768) {
            if (sidebar.classList.contains('open') &&
                !sidebar.contains(e.target) &&
                !menuToggle.contains(e.target)) {
                toggleSidebar();
            }
        }
    });
    // Dropdown Toggles
    const dropdownToggles = document.querySelectorAll('.sidebar-dropdown-toggle');

    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', (e) => {
            e.preventDefault(); // Prevent navigation if it's a link, usually it's an icon or the whole link
            e.stopPropagation();

            const group = toggle.closest('.sidebar-item-group');
            const submenu = group.querySelector('.sidebar-submenu');

            if (submenu) {
                // Simple toggle
                if (submenu.style.display === 'none') {
                    submenu.style.display = 'block';
                    toggle.classList.add('rotated');
                } else {
                    submenu.style.display = 'none';
                    toggle.classList.remove('rotated');
                }
            }
        });
    });

})();
