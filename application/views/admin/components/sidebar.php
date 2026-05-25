<!-- Sidebar Component -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-brand">
            <h2 id="sidebar-title">
                <img src="http://localhost/SIKUBAH/images/PRODUSEN-gold.png" alt="Logo" class="sidebar-logo">
                <span>PKM</span>
            </h2>
        </div>
        <button class="sidebar-toggle btn btn-light btn-sm" id="sidebar-toggle-btn">
            <i class="bi bi-chevron-left"></i>
        </button>
    </div>

    <ul class="sidebar-nav">
        <!-- Dashboard -->
        <li class="nav-item">
            <a href="/SIKUBAH/dashboard" class="nav-link">
                <i class="bi bi-speedometer2"></i>
                <span class="nav-text">Dashboard</span>
            </a>
        </li>

        <!-- Kelolah Pages -->
        <li class="nav-item">
            <a href="#pages-menu" class="nav-link menu-toggle" data-toggle="pages-menu">
                <i class="bi bi-file-earmark"></i>
                <span class="nav-text">Kelolah Pages</span>
                <i class="bi bi-chevron-down menu-icon"></i>
            </a>
            <ul class="submenu" id="pages-menu">
                <!-- <li class="submenu-item">
                    <a href="/SIKUBAH/pages/produk" class="submenu-link">
                        <i class="bi bi-box"></i>
                        <span class="nav-text">Produk</span>
                    </a>
                </li>
                <li class="submenu-item">
                    <a href="/SIKUBAH/pages/kontak" class="submenu-link">
                        <i class="bi bi-telephone"></i>
                        <span class="nav-text">Kontak</span>
                    </a>
                </li> -->
                <li class="submenu-item">
                    <a href="/SIKUBAH/articles" class="submenu-link">
                        <i class="bi bi-file-richtext"></i>
                        <span class="nav-text">Blog Artikel</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Kelolah Konten -->
        <li class="nav-item">
            <a href="#content-menu" class="nav-link menu-toggle" data-toggle="content-menu">
                <i class="bi bi-pencil-square"></i>
                <span class="nav-text">Kelolah Konten</span>
                <i class="bi bi-chevron-down menu-icon"></i>
            </a>
            <ul class="submenu" id="content-menu">
                <li class="submenu-item">
                    <a href="/SIKUBAH/portfolio" class="submenu-link">
                        <i class="bi bi-images"></i>
                        <span class="nav-text">Portofolio</span>
                    </a>
                </li>
                <!-- <li class="submenu-item">
                    <a href="/SIKUBAH/content/produk-kami" class="submenu-link">
                        <i class="bi bi-bag"></i>
                        <span class="nav-text">Produk Kami</span>
                    </a>
                </li> -->
            </ul>
        </li>

        <!-- WhatsApp Statistics -->
        <li class="nav-item">
            <a href="/SIKUBAH/watracking/stats" class="nav-link">
                <i class="bi bi-whatsapp"></i>
                <span class="nav-text">WhatsApp Stats</span>
            </a>
        </li>

        <!-- Pengaturan -->
        <!-- <li class="nav-item">
            <a href="/SIKUBAH/settings" class="nav-link">
                <i class="bi bi-gear"></i>
                <span class="nav-text">Pengaturan</span>
            </a>
        </li> -->
    </ul>

    <div class="sidebar-footer">
        <a href="/SIKUBAH/auth/logout" class="btn btn-danger btn-logout w-100">
            <i class="bi bi-box-arrow-right"></i>
            <span class="nav-text">Logout</span>
        </a>
    </div>
</div>

<style>
    /* Sidebar Styling */
    .sidebar {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        color: white;
        display: flex;
        flex-direction: column;
        transition: all 0.3s ease;
        overflow-y: auto;
        overflow-x: hidden;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        position: relative;
        z-index: 1060;
    }

    .sidebar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        position: relative;
        z-index: 10;
    }

    .sidebar-brand {
        flex: 1;
        cursor: pointer;
        transition: all 0.3s ease;
        padding: 5px;
        border-radius: 6px;
        position: relative;
        z-index: 10;
        pointer-events: auto;
    }

    .sidebar-brand:hover {
        background: rgba(255, 255, 255, 0.1);
    }

    .sidebar-brand h2 {
        font-size: 22px;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
        white-space: nowrap;
    }

    .sidebar-logo {
        width: 50px;
        height: 50px;
        object-fit: contain;
        flex-shrink: 0;
    }

    .sidebar-brand i {
        font-size: 26px;
    }

    .sidebar-toggle {
        background: rgba(255, 255, 255, 0.2) !important;
        color: white !important;
        border: none !important;
        width: 36px;
        height: 36px;
        padding: 0 !important;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: all 0.3s ease;
    }

    .sidebar-toggle:hover {
        background: rgba(255, 255, 255, 0.3) !important;
        transform: scale(1.05);
    }

    .sidebar-toggle i {
        font-size: 18px;
        transition: transform 0.3s ease;
    }

    /* Sidebar Navigation */
    .sidebar-nav {
        list-style: none;
        padding: 15px 0;
        flex: 1;
        overflow-y: auto;
    }

    .nav-item {
        margin: 0;
    }

    .nav-link {
        display: flex;
        align-items: center;
        gap: 12px;
        color: rgba(255, 255, 255, 0.8);
        padding: 12px 20px;
        text-decoration: none;
        transition: all 0.3s ease;
        cursor: pointer;
        border-left: 4px solid transparent;
        position: relative;
    }

    .nav-link:hover,
    .nav-link.active {
        background: rgba(255, 255, 255, 0.15);
        color: white;
        border-left-color: white;
        padding-left: 16px;
    }

    .nav-link i:first-child {
        min-width: 20px;
        font-size: 18px;
    }

    .nav-text {
        flex: 1;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .menu-icon {
        font-size: 14px;
        transition: transform 0.3s ease;
        margin-left: auto;
    }

    .nav-link.menu-toggle.active .menu-icon {
        transform: rotate(180deg);
    }

    /* Submenu */
    .submenu {
        list-style: none;
        margin: 0;
        padding: 0;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease;
        background: rgba(0, 0, 0, 0.15);
    }

    .submenu.show {
        max-height: 500px;
    }

    .submenu-item {
        margin: 0;
    }

    .submenu-link {
        display: flex;
        align-items: center;
        gap: 12px;
        color: rgba(255, 255, 255, 0.7);
        padding: 10px 20px 10px 36px;
        text-decoration: none;
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
        font-size: 14px;
    }

    .submenu-link:hover,
    .submenu-link.active {
        background: rgba(255, 255, 255, 0.1);
        color: white;
        border-left-color: white;
        padding-left: 32px;
    }

    .submenu-link i {
        min-width: 18px;
        font-size: 16px;
    }

    /* Sidebar Footer */
    .sidebar-footer {
        padding: 15px 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        margin-top: auto;
    }

    .btn-logout {
        display: flex;
        align-items: center;
        gap: 8px;
        justify-content: center !important;
        padding: 10px 15px !important;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .btn-logout:hover {
        background: #cc0000 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
    }

    /* Collapsed Sidebar */
    .sidebar.collapsed {
        width: 70px;
    }

    .sidebar.collapsed .sidebar-brand span,
    .sidebar.collapsed .nav-text,
    .sidebar.collapsed .sidebar-toggle {
        display: none;
    }

    .sidebar.collapsed .sidebar-brand h2 {
        justify-content: center;
    }

    .sidebar.collapsed .sidebar-logo {
        width: 50px;
        height: 50px;
    }

    .sidebar.collapsed .nav-link,
    .sidebar.collapsed .submenu-link {
        justify-content: center;
        padding: 12px 0;
    }

    .sidebar.collapsed .nav-link {
        border-left: none;
        border-bottom: 3px solid transparent;
    }

    .sidebar.collapsed .nav-link:hover,
    .sidebar.collapsed .nav-link.active {
        background: rgba(255, 255, 255, 0.2);
        border-left: none;
        border-bottom-color: white;
    }

    .sidebar.collapsed .menu-icon {
        display: none;
    }

    .sidebar.collapsed .submenu {
        display: none;
    }

    /* Scrollbar */
    .sidebar::-webkit-scrollbar {
        width: 6px;
    }

    .sidebar::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.05);
    }

    .sidebar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 3px;
    }

    .sidebar::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.3);
    }
</style>

<script>
    // Sidebar Toggle Functionality
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('sidebar-toggle-btn');
        const sidebarBrand = document.querySelector('.sidebar-brand');
        const menuToggles = document.querySelectorAll('.menu-toggle');
        const currentUrl = window.location.pathname;

        // Set active menu based on current URL
        function setActiveMenu() {
            // Remove all active classes
            document.querySelectorAll('.nav-link, .submenu-link').forEach(link => {
                link.classList.remove('active');
            });

            // Find and mark active links
            const allLinks = document.querySelectorAll('.nav-link, .submenu-link');
            let activeSubmenuId = null;

            allLinks.forEach(link => {
                const href = link.getAttribute('href');
                // Check if current URL matches or contains the href
                if (href && href !== '#' && href !== '#pages-menu' && href !== '#content-menu') {
                    // Normalize URLs for comparison
                    const normalizedHref = href.toLowerCase();
                    const normalizedUrl = currentUrl.toLowerCase();

                    if (normalizedUrl.includes(normalizedHref) || normalizedHref === normalizedUrl) {
                        link.classList.add('active');

                        // If this is a submenu link, find parent submenu to open
                        const parentSubmenu = link.closest('.submenu');
                        if (parentSubmenu) {
                            activeSubmenuId = parentSubmenu.id;
                        }
                    }
                }
            });

            // Open submenu if active link is inside it
            if (activeSubmenuId) {
                const submenu = document.getElementById(activeSubmenuId);
                const toggle = document.querySelector(`[data-toggle="${activeSubmenuId}"]`);
                if (submenu) {
                    submenu.classList.add('show');
                }
                if (toggle) {
                    toggle.classList.add('active');
                }
            }

            // Handle Dashboard link - active if on /SIKUBAH/dashboard
            if (currentUrl.includes('/dashboard')) {
                document.querySelector('.nav-link[href="/SIKUBAH/dashboard"]')?.classList.add('active');
            }
        }

        // Call on page load
        setActiveMenu();

        // Toggle sidebar collapse with button
        if (toggleBtn) {
            toggleBtn.addEventListener('click', function(e) {
                e.preventDefault();
                sidebar.classList.toggle('collapsed');
                localStorage.setItem('sidebar-collapsed', sidebar.classList.contains('collapsed'));
            });
        }

        // Toggle sidebar by clicking brand/logo
        if (sidebarBrand) {
            sidebarBrand.addEventListener('click', function(e) {
                e.preventDefault();
                // If collapsed, expand it
                if (sidebar.classList.contains('collapsed')) {
                    sidebar.classList.remove('collapsed');
                    localStorage.setItem('sidebar-collapsed', false);
                }
            });
        }

        // Restore sidebar state
        if (localStorage.getItem('sidebar-collapsed') === 'true') {
            sidebar.classList.add('collapsed');
        }

        // Toggle submenu
        menuToggles.forEach(toggle => {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                const menuId = this.getAttribute('data-toggle');
                const submenu = document.getElementById(menuId);

                if (sidebar.classList.contains('collapsed')) {
                    return; // Don't open submenu when sidebar is collapsed
                }

                // Close other menus
                document.querySelectorAll('.submenu').forEach(menu => {
                    if (menu.id !== menuId) {
                        menu.classList.remove('show');
                        const toggleEl = document.querySelector(`[data-toggle="${menu.id}"]`);
                        if (toggleEl) {
                            toggleEl.classList.remove('active');
                        }
                    }
                });

                // Toggle current menu
                submenu.classList.toggle('show');
                this.classList.toggle('active');
            });
        });
    });
</script>