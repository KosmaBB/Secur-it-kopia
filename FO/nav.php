<div class="holo-sidebar" id="holo-sidebar">
    <div class="holo-sidebar-header">
        <div class="holo-logo">
            <a href="../FO/index.php">
                <img src="../images/logo.png" alt="Secur IT Logo">
            </a>
        </div>
        <div class="holo-toggle" id="holo-toggle">
            <div class="holo-toggle-icon">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    
    <div class="holo-sidebar-content">
        <div class="holo-scan-effect"></div>
        <div class="holo-grid-lines"></div>
        
        <ul class="holo-menu">
            <li class="holo-menu-item">
                <a href="../FO/index.php" class="holo-menu-link">
                    <i class="fa fa-home"></i>
                    <span class="holo-menu-text">Strona główna</span>
                </a>
            </li>
                        <!-- Nowe submenu "O firmie" -->
            <li class="holo-menu-item has-submenu">
                <a href="#" class="holo-menu-link holo-submenu-toggle">
                    <i class="fa fa-info-circle"></i>
                    <span class="holo-menu-text">O firmie</span>
                    <i class="fa fa-chevron-down holo-submenu-icon"></i>
                </a>
                <ul class="holo-submenu">
                    <li class="holo-submenu-back">
                        <a href="#" class="holo-back-link">
                            <i class="fa fa-arrow-left"></i>
                            <span>Powrót</span>
                        </a>
                    </li>
                    <li class="holo-submenu-item">
                        <a href="../FO/about_company.php" class="holo-submenu-link">
                            <span class="holo-submenu-text">O nas</span>
                        </a>
                    </li>
                    <li class="holo-submenu-item">
                        <a href="../FO/employees.php" class="holo-submenu-link">
                            <span class="holo-submenu-text">Nasz zespół</span>
                        </a>
                    </li>
                    <li class="holo-submenu-item">
                        <a href="../FO/posts.php" class="holo-submenu-link">
                            <span class="holo-submenu-text">Oceny</span>
                        </a>
                    </li>
                </ul>
            </li>
            </li>
            <li class="holo-menu-item has-submenu">
                <a href="#" class="holo-menu-link holo-submenu-toggle">
                    <i class="fa fa-briefcase"></i>
                    <span class="holo-menu-text">Oferta</span>
                    <i class="fa fa-chevron-down holo-submenu-icon"></i>
                </a>
                <ul class="holo-submenu">
                    <li class="holo-submenu-back">
                        <a href="#" class="holo-back-link">
                            <i class="fa fa-arrow-left"></i>
                            <span>Powrót</span>
                        </a>
                    </li>
                    <li class="holo-submenu-item">
                        <a href="../FO/networks.php" class="holo-submenu-link">
                            <span class="holo-submenu-text">Sieci</span>
                        </a>
                    </li>
                    <li class="holo-submenu-item">
                        <a href="../FO/systems.php" class="holo-submenu-link">
                            <span class="holo-submenu-text">Systemy</span>
                        </a>
                    </li>
                    <li class="holo-submenu-item">
                        <a href="../FO/websites.php" class="holo-submenu-link">
                            <span class="holo-submenu-text">Strony internetowe</span>
                        </a>
                    </li>
                    <li class="holo-submenu-item">
                        <a href="../FO/databases.php" class="holo-submenu-link">
                            <span class="holo-submenu-text">Bazy danych</span>
                        </a>
                    </li>
                    <li class="holo-submenu-item">
                        <a href="../FO/computer_service.php" class="holo-submenu-link">
                            <span class="holo-submenu-text">Serwis sprzętu</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="holo-menu-item">
                <a href="../FO/contact.php" class="holo-menu-link">
                    <i class="fa fa-envelope"></i>
                    <span class="holo-menu-text">Kontakt</span>
                </a>
            </li>
            
            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
            <li class="holo-menu-item has-submenu">
                <a href="#" class="holo-menu-link holo-submenu-toggle">
                    <i class="fa fa-user-circle"></i>
                    <span class="holo-menu-text">Konto</span>
                    <i class="fa fa-chevron-down holo-submenu-icon"></i>
                </a>
                <ul class="holo-submenu">
                    <li class="holo-submenu-back">
                        <a href="#" class="holo-back-link">
                            <i class="fa fa-arrow-left"></i>
                            <span>Powrót</span>
                        </a>
                    </li>
                    <li class="holo-submenu-item">
                        <a href="../FO/account.php" class="holo-submenu-link">
                            <span class="holo-submenu-text">Panel konta</span>
                        </a>
                    </li>
                    <li class="holo-submenu-item">
                        <a href="../FO/basket.php" class="holo-submenu-link">
                            <span class="holo-submenu-text">Koszyk</span>
                        </a>
                    </li>
                    <li class="holo-submenu-item">
                        <a href="../FO/logout.php" class="holo-submenu-link">
                            <span class="holo-submenu-text">Wyloguj</span>
                        </a>
                    </li>
                </ul>
            </li>
            
            <?php if (isset($is_admin) && $is_admin == 1): ?>
            <li class="holo-menu-item">
                <a href="../BO/admin_panel.php" class="holo-menu-link holo-admin-link">
                    <i class="fa fa-shield"></i>
                    <span class="holo-menu-text">Panel Administratora</span>
                </a>
            </li>
            <?php endif; ?>
            
            <?php else: ?>
            <li class="holo-menu-item">
                <a href="../FO/login.php" class="holo-menu-link">
                    <i class="fa fa-user"></i>
                    <span class="holo-menu-text">Logowanie</span>
                </a>
            </li>
            <?php endif; ?>
        </ul>
    </div>
    

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('holo-sidebar');
    const toggleBtn = document.getElementById('holo-toggle');
    const submenuToggles = document.querySelectorAll('.holo-submenu-toggle');
    const backLinks = document.querySelectorAll('.holo-submenu-back a');

    toggleBtn.addEventListener('click', function() {
        sidebar.classList.toggle('collapsed');
        
        if (sidebar.classList.contains('collapsed')) {
            localStorage.setItem('holoSidebarState', 'collapsed');
        } else {
            localStorage.setItem('holoSidebarState', 'expanded');
        }
    });
    
    const savedState = localStorage.getItem('holoSidebarState');
    if (savedState === 'collapsed') {
        sidebar.classList.add('collapsed');
    }
    
    submenuToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            submenuToggles.forEach(otherToggle => {
                if (otherToggle !== toggle) {
                    otherToggle.classList.remove('active');
                    const otherSubmenu = otherToggle.closest('.holo-menu-item').querySelector('.holo-submenu');
                    if (otherSubmenu) {
                        otherSubmenu.classList.remove('open');
                    }
                }
            });
            
            toggle.classList.toggle('active');
            const submenu = toggle.closest('.holo-menu-item').querySelector('.holo-submenu');
            submenu.classList.toggle('open');
            
            if (sidebar.classList.contains('collapsed')) {
                sidebar.classList.remove('collapsed');
                localStorage.setItem('holoSidebarState', 'expanded');
            }
        });
    });
    
    backLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const submenu = link.closest('.holo-submenu');
            submenu.classList.remove('open');
            const toggle = submenu.closest('.holo-menu-item').querySelector('.holo-submenu-toggle');
            toggle.classList.remove('active');
        });
    });
    
    const body = document.body;
    const mobileToggle = document.createElement('div');
    mobileToggle.className = 'holo-mobile-toggle';
    mobileToggle.innerHTML = '<i class="fa fa-bars"></i>';
    body.appendChild(mobileToggle);
    
    const overlay = document.createElement('div');
    overlay.className = 'holo-overlay';
    body.appendChild(overlay);
    
    mobileToggle.addEventListener('click', function() {
        sidebar.classList.add('mobile-open');
        overlay.classList.add('active');
    });
    
    overlay.addEventListener('click', function() {
        sidebar.classList.remove('mobile-open');
        overlay.classList.remove('active');
    });
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            sidebar.classList.remove('mobile-open');
            overlay.classList.remove('active');
        }
    });
    
    const currentPage = window.location.pathname.split('/').pop();
    const menuLinks = document.querySelectorAll('.holo-menu-link');
    
    menuLinks.forEach(link => {
        const href = link.getAttribute('href');
        if (href === currentPage) {
            link.classList.add('active');
            
            const parentItem = link.closest('.holo-submenu-item');
            if (parentItem) {
                const parentSubmenu = parentItem.closest('.holo-submenu');
                parentSubmenu.classList.add('open');
                const parentToggle = parentSubmenu.closest('.holo-menu-item').querySelector('.holo-submenu-toggle');
                parentToggle.classList.add('active');
            }
        }
    });
});
</script>