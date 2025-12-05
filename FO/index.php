<?php
    include_once ('../include/functions.php');
?>
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="./script.js" defer></script>
        <script src="https://kit.fontawesome.com/1deffa5961.js" crossorigin="anonymous"></script>
        <link rel="shortcut icon" href="../images/ikona.png">
        <title>Secur IT | Strona główna</title>
    </head>
    <body>
        <div class="holo-background">
            <div class="holo-grid-lines"></div>
            <div class="holo-particles"></div>
        </div>
        

        <?php include("nav.php"); ?>
        
        <main class="main" id="main">
            <section class="hero-section">
                <div class="hero-hologram">
                </div>
                
                <div class="hero-content">
                    <h1 class="hero-title">
                        <span class="glitch-effect" data-text="SECUR IT">SECUR IT</span>
                    </h1>
                    <p class="hero-subtitle">Kompleksowe rozwiązania IT dla Twojego biznesu. Bezpieczeństwo, niezawodność i innowacje.</p>
                    <div class="hero-buttons">
                        <a href="contact.php" class="holo-button">
                            <i class="fa fa-envelope"></i>
                            <span>Skontaktuj się z nami</span>
                        </a>
                    </div>
                </div>
            </section>
            
            <section class="services-section">
                <div class="section-header">
                    <h2 class="section-title">Nasze Usługi</h2>
                    <p class="section-subtitle">Oferujemy kompleksowe rozwiązania IT dostosowane do potrzeb Twojej firmy</p>
                </div>
                
                <div class="services-grid">
                    <div class="service-card">
                        <a href="networks.php">
                            <div class="service-icon">
                                <i class="fa fa-network-wired"></i>
                            </div>
                            <h3 class="service-title">Sieci Komputerowe</h3>
                            <p class="service-description">Projektowanie, wdrażanie i zarządzanie sieciami komputerowymi dla firm każdej wielkości.</p>
                        </a>
                    </div>
                    
                    <div class="service-card">
                        <a href="servers.php">
                            <div class="service-icon">
                                <i class="fa fa-server"></i>
                            </div>
                            <h3 class="service-title">Systemy Serwerowe</h3>
                            <p class="service-description">Konfiguracja i utrzymanie wydajnych systemów serwerowych dostosowanych do potrzeb biznesowych.</p>
                        </a>
                    </div>
                    
                    <div class="service-card">
                        <a href="websites.php">
                            <div class="service-icon">
                                <i class="fa fa-code"></i>
                            </div>
                            <h3 class="service-title">Strony Internetowe</h3>
                            <p class="service-description">Tworzenie nowoczesnych, responsywnych stron internetowych i aplikacji webowych.</p>
                        </a>
                    </div>
                    
                    <div class="service-card">
                        <a href="databases.php">
                            <div class="service-icon">
                                <i class="fa fa-database"></i>
                            </div>
                            <h3 class="service-title">Bazy Danych</h3>
                            <p class="service-description">Projektowanie, implementacja i optymalizacja baz danych dla efektywnego zarządzania informacjami.</p>
                        </a>
                    </div>
                    
                    <div class="service-card">
                        <a href="service.php">
                            <div class="service-icon">
                                <i class="fa fa-laptop-medical"></i>
                            </div>
                            <h3 class="service-title">Serwis Sprzętu</h3>
                            <p class="service-description">Profesjonalny serwis i naprawa sprzętu komputerowego oraz urządzeń peryferyjnych.</p>
                        </a>
                    </div>
                </div>
            </section>
            
            <section class="about-section">
                <div class="about-container">
                    <div class="about-image">
                        <div class="about-image-frame">
                            <div class="about-image-inner"></div>
                            <div class="about-image-overlay"></div>
                            <div class="about-image-scan"></div>
                        </div>
                    </div>
                    
                    <div class="about-content">
                        <h2 class="about-title">O Firmie Secur IT</h2>
                        <p class="about-text">Secur IT to firma specjalizująca się w dostarczaniu kompleksowych rozwiązań IT dla firm i klientów indywidualnych. Naszym celem jest zapewnienie najwyższej jakości usług, które pomogą naszym klientom osiągnąć przewagę konkurencyjną.</p>
                        
                        <div class="about-features">
                            <div class="about-feature">
                                <div class="about-feature-icon">
                                    <i class="fa fa-check"></i>
                                </div>
                                <div class="about-feature-text">Profesjonalny zespół</div>
                            </div>
                            
                            <div class="about-feature">
                                <div class="about-feature-icon">
                                    <i class="fa fa-check"></i>
                                </div>
                                <div class="about-feature-text">Indywidualne podejście</div>
                            </div>
                            
                            <div class="about-feature">
                                <div class="about-feature-icon">
                                    <i class="fa fa-check"></i>
                                </div>
                                <div class="about-feature-text">Nowoczesne technologie</div>
                            </div>
                            
                            <div class="about-feature">
                                <div class="about-feature-icon">
                                    <i class="fa fa-check"></i>
                                </div>
                                <div class="about-feature-text">Wsparcie techniczne</div>
                            </div>
                        </div>
                        
                        <a href="about_company.php" class="holo-button">
                            <i class="fa fa-info-circle"></i>
                            <span>Dowiedz się więcej</span>
                        </a>
                    </div>
                </div>
            </section>
            
            <!-- Sekcja osiągnięć - ukryta, ale gotowa do przywrócenia -->
            <!-- Aby przywrócić tę sekcję, zmień 'display: none;' na 'display: block;' w klasie .stats-section w CSS -->
            <section class="stats-section">
                <div class="section-header">
                    <h2 class="section-title">Nasze Osiągnięcia</h2>
                    <p class="section-subtitle">Liczby, które mówią same za siebie</p>
                </div>
                
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fa fa-project-diagram"></i>
                        </div>
                        <div class="stat-value" data-value="150">0</div>
                        <div class="stat-label">Zrealizowanych projektów</div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fa fa-users"></i>
                        </div>
                        <div class="stat-value" data-value="50">0</div>
                        <div class="stat-label">Stałych klientów</div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fa fa-clock"></i>
                        </div>
                        <div class="stat-value" data-value="8">0</div>
                        <div class="stat-label">Lat doświadczenia</div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fa fa-star"></i>
                        </div>
                        <div class="stat-value" data-value="99.9">0</div>
                        <div class="stat-label">% zadowolonych klientów</div>
                    </div>
                </div>
            </section>
            
            <!-- Sekcja projektów - ukryta, ale gotowa do przywrócenia -->
            <!-- Aby przywrócić tę sekcję, zmień 'display: none;' na 'display: block;' w klasie .projects-section w CSS -->
            <section class="projects-section">
                <div class="section-header">
                    <h2 class="section-title">Nasze Projekty</h2>
                    <p class="section-subtitle">Poznaj nasze najnowsze realizacje</p>
                </div>
                
                <div class="projects-grid">
                    <div class="project-card">
                        <div class="project-image">
                            <img src="../images/projects/project1.jpg" alt="Projekt 1">
                            <div class="project-overlay"></div>
                        </div>
                        <div class="project-content">
                            <h3 class="project-title">System bezpieczeństwa dla firmy XYZ</h3>
                            <p class="project-description">Wdrożenie kompleksowego systemu bezpieczeństwa IT dla dużej firmy produkcyjnej.</p>
                            <div class="project-tags">
                                <span class="project-tag">Bezpieczeństwo</span>
                                <span class="project-tag">Firewall</span>
                                <span class="project-tag">VPN</span>
                            </div>
                            <a href="#" class="project-link">
                                <span>Szczegóły projektu</span>
                                <i class="fa fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    
                    <div class="project-card">
                        <div class="project-image">
                            <img src="../images/projects/project2.jpg" alt="Projekt 2">
                            <div class="project-overlay"></div>
                        </div>
                        <div class="project-content">
                            <h3 class="project-title">Infrastruktura sieciowa dla biurowca</h3>
                            <p class="project-description">Zaprojektowanie i wdrożenie nowoczesnej infrastruktury sieciowej dla biurowca klasy A.</p>
                            <div class="project-tags">
                                <span class="project-tag">Sieci</span>
                                <span class="project-tag">Infrastruktura</span>
                                <span class="project-tag">Serwery</span>
                            </div>
                            <a href="#" class="project-link">
                                <span>Szczegóły projektu</span>
                                <i class="fa fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    
                    <div class="project-card">
                        <div class="project-image">
                            <img src="../images/projects/project3.jpg" alt="Projekt 3">
                            <div class="project-overlay"></div>
                        </div>
                        <div class="project-content">
                            <h3 class="project-title">Platforma e-commerce</h3>
                            <p class="project-description">Stworzenie zaawansowanej platformy e-commerce z integracją systemów płatności i magazynowych.</p>
                            <div class="project-tags">
                                <span class="project-tag">E-commerce</span>
                                <span class="project-tag">Web Development</span>
                                <span class="project-tag">Integracje</span>
                            </div>
                            <a href="#" class="project-link">
                                <span>Szczegóły projektu</span>
                                <i class="fa fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
            <section class="cta-section">
                <div class="cta-container">
                    <h2 class="cta-title">Gotowy na współpracę?</h2>
                    <p class="cta-text">Skontaktuj się z nami już dziś, aby omówić, jak możemy pomóc Twojej firmie osiągnąć sukces dzięki nowoczesnym rozwiązaniom IT.</p>
                    <a href="contact.php" class="holo-button">
                        <i class="fa fa-envelope"></i>
                        <span>Skontaktuj się z nami</span>
                    </a>
                </div>
            </section>
            
            <?php include("footer.php"); ?>
        </main>
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const sidebar = document.getElementById('holo-sidebar');
                const main = document.getElementById('main');
                
                const savedState = localStorage.getItem('holoSidebarState');
                if (savedState === 'collapsed') {
                    main.classList.add('sidebar-collapsed');
                }
                
                const observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                            if (sidebar.classList.contains('collapsed')) {
                                main.classList.add('sidebar-collapsed');
                            } else {
                                main.classList.remove('sidebar-collapsed');
                            }
                        }
                    });
                });
                
                observer.observe(sidebar, { attributes: true });
                
                window.addEventListener('scroll', function() {
                    const scrollY = window.scrollY;
                    const particles = document.querySelector('.holo-particles');
                    
                    if (particles) {
                        particles.style.transform = `translateY(${scrollY * 0.2}px)`;
                    }
                });
                
                function animateStats() {
                    const statValues = document.querySelectorAll('.stat-value');
                    
                    statValues.forEach(stat => {
                        const targetValue = parseFloat(stat.getAttribute('data-value'));
                        const duration = 2000; // 2 sekundy
                        const startTime = Date.now();
                        
                        const updateCounter = () => {
                            const currentTime = Date.now();
                            const progress = Math.min((currentTime - startTime) / duration, 1);
                            
                            const currentValue = progress * targetValue;
                            
                            if (Number.isInteger(targetValue)) {
                                stat.textContent = Math.floor(currentValue);
                            } else {
                                stat.textContent = currentValue.toFixed(1);
                            }
                            
                            if (progress < 1) {
                                requestAnimationFrame(updateCounter);
                            }
                        };
                        
                        updateCounter();
                    });
                }
                
                const statsSection = document.querySelector('.stats-section');
                
                if (statsSection && statsSection.style.display !== 'none') {
                    const observer2 = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                animateStats();
                                observer2.unobserve(entry.target);
                            }
                        });
                    }, { threshold: 0.2 });
                    
                    observer2.observe(statsSection);
                }
            });
        </script>
    </body>
</html>