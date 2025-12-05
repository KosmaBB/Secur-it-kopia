<?php
    include_once ('../include/functions.php');
    include_once('../DB/db_accounts.php');
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
        <title>Secur IT | Konto</title>
    </head>
    <body>
        <div class="tlo"></div>
        <main class="main">
            <?php

                include("nav.php");
                
                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                    $id_user = $_SESSION['id_user'];

                    $baza = new db_accounts();
                    $baza->databaseConnect();
                    $data = $baza->selectCustomerById($id_user, null);

                    if ($data && mysqli_num_rows($data) > 0) {
                        $user = mysqli_fetch_assoc($data);
                        ?>
                        
                        <div class="holo-account">
                            <div class="holo-container">
                                <div class="holo-header">
                                    <div class="holo-welcome">
                                        <h1>Witaj, <span class="holo-highlight"><?php echo $user['username']; ?></span></h1>
                                        <p>Panel użytkownika Secur IT</p>
                                    </div>
                                    <div class="holo-avatar">
                                        <div class="holo-avatar-circle">
                                            <i class="fa fa-user"></i>
                                        </div>
                                        <div class="holo-status">
                                            <span class="holo-status-dot"></span>
                                            <span>Online</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="holo-tabs">
                                    <button class="holo-tab active" data-tab="profile">
                                        <i class="fa fa-user"></i>
                                        <span>Profil</span>
                                    </button>
                                    <?php if (!empty($user['company_name'])): ?>
                                    <button class="holo-tab" data-tab="company">
                                        <i class="fa fa-building"></i>
                                        <span>Firma</span>
                                    </button>
                                    <?php endif; ?>
                                    <button class="holo-tab" data-tab="security">
                                        <i class="fa fa-shield-alt"></i>
                                        <span>Bezpieczeństwo</span>
                                    </button>
                                </div>
                                
                                <div class="holo-content">
                                    <div class="holo-tab-content active" id="profile-tab">
                                        <div class="holo-card">
                                            <div class="holo-card-header">
                                                <h2>Dane osobowe</h2>
                                                <div class="holo-card-actions">
                                                    <a href="./edit_account.php" class="holo-action-button">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            
                                            <div class="holo-card-body">
                                                <div class="holo-info-grid">
                                                    <div class="holo-info-item">
                                                        <div class="holo-info-label">Imię</div>
                                                        <div class="holo-info-value"><?php echo $user['first_name']; ?></div>
                                                    </div>
                                                    <div class="holo-info-item">
                                                        <div class="holo-info-label">Nazwisko</div>
                                                        <div class="holo-info-value"><?php echo $user['last_name']; ?></div>
                                                    </div>
                                                    <div class="holo-info-item">
                                                        <div class="holo-info-label">Telefon</div>
                                                        <div class="holo-info-value"><?php echo $user['ucc'] . ' ' . $user['upn']; ?></div>
                                                    </div>
                                                    <div class="holo-info-item">
                                                        <div class="holo-info-label">Email</div>
                                                        <div class="holo-info-value"><?php echo $user['uea']; ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="holo-card">
                                            <div class="holo-card-header">
                                                <h2>Ustawienia konta</h2>
                                            </div>
                                            
                                            <div class="holo-card-body">
                                                <div class="holo-actions">
                                                    <a href="./change_password.php" class="holo-button">
                                                        <i class="fa fa-key"></i>
                                                        <span>Zmień hasło</span>
                                                    </a>
                                                    <a href="./edit_account.php" class="holo-button">
                                                        <i class="fa fa-user-edit"></i>
                                                        <span>Edytuj dane</span>
                                                    </a>
                                                    <a href="./logout.php" class="holo-button logout">
                                                        <i class="fa fa-sign-out-alt"></i>
                                                        <span>Wyloguj się</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <?php if (!empty($user['company_name'])): ?>
                                    <div class="holo-tab-content" id="company-tab">
                                        <div class="holo-card">
                                            <div class="holo-card-header">
                                                <h2>Dane firmy</h2>
                                                <?php if ($user['is_company_admin'] == 1): ?>
                                                <div class="holo-card-actions">
                                                    <a href="./edit_company.php" class="holo-action-button">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <div class="holo-card-body">
                                                <div class="holo-company-status">
                                                    <?php if ($user['is_company_admin']): ?>
                                                    <div class="holo-badge admin">Administrator</div>
                                                    <?php else: ?>
                                                    <div class="holo-badge employee">Pracownik</div>
                                                    <?php endif; ?>
                                                </div>
                                                
                                                <div class="holo-info-grid">
                                                    <div class="holo-info-item">
                                                        <div class="holo-info-label">Nazwa firmy</div>
                                                        <div class="holo-info-value"><?php echo $user['company_name'] . ' ' . $user['additional_name']; ?></div>
                                                    </div>
                                                    <div class="holo-info-item">
                                                        <div class="holo-info-label">NIP</div>
                                                        <div class="holo-info-value"><?php echo $user['tax']; ?></div>
                                                    </div>
                                                    <div class="holo-info-item">
                                                        <div class="holo-info-label">Telefon</div>
                                                        <div class="holo-info-value"><?php echo $user['ccc'] . ' ' . $user['cpn']; ?></div>
                                                    </div>
                                                    <div class="holo-info-item">
                                                        <div class="holo-info-label">Email</div>
                                                        <div class="holo-info-value"><?php echo $user['cea']; ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <?php if ($user['is_company_admin']): ?>
                                        <div class="holo-card">
                                            <div class="holo-card-header">
                                                <h2>Zarządzanie firmą</h2>
                                            </div>
                                            
                                            <div class="holo-card-body">
                                                <div class="holo-actions">
                                                    <?php if ($user['id_company'] != 1 && $user['is_company_admin']): ?>
                                                    <a href="./add_employee.php" class="holo-button">
                                                        <i class="fa fa-user-plus"></i>
                                                        <span>Dodaj pracownika</span>
                                                    </a>
                                                    <?php endif; ?>
                                                    
                                                    <?php if ($user['is_company_admin'] == 1): ?>
                                                    <a href="./view_employee.php" class="holo-button">
                                                        <i class="fa fa-users"></i>
                                                        <span>Wyświetl pracowników</span>
                                                    </a>
                                                    <a href="./edit_company.php" class="holo-button">
                                                        <i class="fa fa-building"></i>
                                                        <span>Edytuj dane firmy</span>
                                                    </a>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <div class="holo-tab-content" id="security-tab">
                                        <div class="holo-card">
                                            <div class="holo-card-header">
                                                <h2>Bezpieczeństwo konta</h2>
                                            </div>
                                            
                                            <div class="holo-card-body">
                                                <div class="holo-security-status">
                                                    <div class="holo-security-icon">
                                                        <i class="fa fa-shield-alt"></i>
                                                    </div>
                                                    <div class="holo-security-info">
                                                        <h3>Status zabezpieczeń</h3>
                                                        <div class="holo-progress">
                                                            <div class="holo-progress-bar" style="width: 80%"></div>
                                                        </div>
                                                        <div class="holo-security-level">Dobry</div>
                                                    </div>
                                                </div>
                                                
                                                <div class="holo-security-tips">
                                                    <div class="holo-security-tip">
                                                        <i class="fa fa-check-circle"></i>
                                                        <span>Twoje konto jest aktywne</span>
                                                    </div>
                                                    <div class="holo-security-tip">
                                                        <i class="fa fa-info-circle"></i>
                                                        <span>Zalecamy regularne zmiany hasła</span>
                                                    </div>
                                                    <div class="holo-security-tip">
                                                        <i class="fa fa-info-circle"></i>
                                                        <span>Używaj silnych haseł zawierających małe i wielkie litery, cyfry oraz znaki specjalne</span>
                                                    </div>
                                                </div>
                                                
                                                <div class="holo-actions">
                                                    <a href="./change_password.php" class="holo-button">
                                                        <i class="fa fa-key"></i>
                                                        <span>Zmień hasło</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="holo-card">
                                            <div class="holo-card-header">
                                                <h2>Ostatnie logowania</h2>
                                            </div>
                                            
                                            <div class="holo-card-body">
                                                <div class="holo-login-history">
                                                    <div class="holo-login-item">
                                                        <div class="holo-login-icon success">
                                                            <i class="fa fa-check"></i>
                                                        </div>
                                                        <div class="holo-login-details">
                                                            <div class="holo-login-date">Dzisiaj, <?php echo date('H:i'); ?></div>
                                                            <div class="holo-login-ip">IP: <?php echo $_SERVER['REMOTE_ADDR']; ?></div>
                                                        </div>
                                                        <div class="holo-login-status">Udane</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <?php
                    } else {
                        echo '<div class="login-message"><p>Nie znaleziono danych użytkownika.</p></div>';
                    }
                    $baza->close();
                } else {
                    echo '<div class="login-message"><p>Musisz być <a href="./login.php">zalogowany</a>, aby zobaczyć tę stronę.</p></div>';
                }
                
                include("footer.php");
            ?>
        </main>
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Obsługa zakładek
                const tabs = document.querySelectorAll('.holo-tab');
                const tabContents = document.querySelectorAll('.holo-tab-content');
                
                tabs.forEach(tab => {
                    tab.addEventListener('click', () => {
                        // Usuń klasę active ze wszystkich zakładek i zawartości
                        tabs.forEach(t => t.classList.remove('active'));
                        tabContents.forEach(content => content.classList.remove('active'));
                        
                        // Dodaj klasę active do klikniętej zakładki
                        tab.classList.add('active');
                        
                        // Pokaż odpowiednią zawartość
                        const tabId = tab.getAttribute('data-tab');
                        document.getElementById(`${tabId}-tab`).classList.add('active');
                    });
                });
                
                // Animacja paska postępu
                const progressBar = document.querySelector('.holo-progress-bar');
                if (progressBar) {
                    setTimeout(() => {
                        progressBar.style.width = '80%';
                    }, 500);
                }
                
                // Efekt hover dla kart
                const cards = document.querySelectorAll('.holo-card');
                cards.forEach(card => {
                    card.addEventListener('mouseenter', () => {
                        card.style.boxShadow = `0 10px 30px rgba(0, 0, 0, 0.3), 0 0 20px rgba(0, 204, 255, 0.3)`;
                    });
                    
                    card.addEventListener('mouseleave', () => {
                        card.style.boxShadow = `0 5px 20px rgba(0, 0, 0, 0.2)`;
                    });
                });
                
                // Efekt skanowania dla avatara
                const avatarCircles = document.querySelectorAll('.holo-avatar-circle');
                avatarCircles.forEach(circle => {
                    setInterval(() => {
                        circle.classList.add('scanning');
                        setTimeout(() => {
                            circle.classList.remove('scanning');
                        }, 1500);
                    }, 5000);
                });
            });
        </script>
    </body>
</html>