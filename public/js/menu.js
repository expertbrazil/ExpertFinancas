document.addEventListener('DOMContentLoaded', function() {
    // Toggle submenu
    const submenus = document.querySelectorAll('.has-submenu');
    submenus.forEach(menu => {
        menu.addEventListener('click', function(e) {
            e.preventDefault();
            this.querySelector('.submenu').classList.toggle('show');
            this.classList.toggle('active');
        });
    });

    // Mobile menu toggle
    const menuToggle = document.querySelector('.mobile-toggle');
    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('show');
        });
    }

    // Close menu when clicking outside on mobile
    document.addEventListener('click', function(e) {
        const sidebar = document.querySelector('.sidebar');
        const toggle = document.querySelector('.mobile-toggle');
        
        if (window.innerWidth <= 1024 && 
            !sidebar.contains(e.target) && 
            !toggle.contains(e.target)) {
            sidebar.classList.remove('show');
        }
    });
});
