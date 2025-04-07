<nav class="top-nav">
    <a class="logo" href="./index.php"><img src="../images/logo.png" alt="logo"></a>                    
    <div class="top-nav-buttons">
        <div class="dropdown">
            <div class="dropdown-top">
                <div class="dropdown-logo">Firma</div>
            <div class="dropdown-toggle">
                <i class="fa-solid fa-bars"></i>
                </div>
            </div>
            <ol class="dropdown-list">
                <li class="dropdown-item" style="--i:1;--j:2"><a href="./about_company.php"></a>O Firmie</li>
                <li class="dropdown-item" style="--i:2;--j:2"><a href="./employees.php"></a>Pracownicy</li>
                <li class="dropdown-item" style="--i:3;--j:1"><a href="./posts.php"></a>Wpisy</li>
            </ol>
        </div>
        <div class="dropdown">
            <div class="dropdown-top">
                <div class="dropdown-logo">Usługi</div>
                <div class="dropdown-toggle">
                    <i class="fa-solid fa-bars"></i>
                </div>
            </div>
            <ol class="dropdown-list">
                <li class="dropdown-item" style="--i:1;--j:5"><a href="./networks.php"></a>Sieci komputerowe</li>
                <li class="dropdown-item" style="--i:2;--j:4"><a href="./systems.php"></a>Systemy Operacyjne</li>
                <li class="dropdown-item" style="--i:3;--j:3"><a href="./databases.php"></a>Bazy Danych</li>
                <li class="dropdown-item" style="--i:4;--j:2"><a href="./websites.php"></a>Strony Internetowe</li>
                <li class="dropdown-item" style="--i:5;--j:1"><a href="./computer_service.php"></a>Serwis Komputerowy</li>
            </ol>
        </div>
        <div class="dropdown-kontakt">
            <div class="dropdown-top-kontakt">
                <a href="contact.php">Kontakt</a>
            </div>
        </div>
        <?php
            if($is_admin == 1){
        ?>
        <div class="dropdown-kontakt">
            <div class="dropdown-top-kontakt">
                <a href="../BO/admin_panel.php">Panel Administratora</a>
            </div>
        </div>
        <?php
            }
        ?>
    </div>
    <div class="phone">
        <div class="dropdown">
            <div class="dropdown-top">
                <div class="dropdown-toggle-phone">
                    <i class="fa-solid fa-bars"></i>
                </div>
            </div>
            <ol class="dropdown-list">
                <li class="dropdown-item" style="--i:1;--j:10"><a href="./about_company.php"></a>O Firmie</li>
                <li class="dropdown-item" style="--i:2;--j:9"><a href="./employees.php"></a>Pracownicy</li>
                <li class="dropdown-item" style="--i:3;--j:8"><a href="./posts.php"></a>Wpisy</li>
                <li class="dropdown-item" style="--i:4;--j:7"><a href="./networks.php"></a>Sieci komputerowe</li>
                <li class="dropdown-item" style="--i:5;--j:6"><a href="./systems.php"></a>Systemy Operacyjne</li>
                <li class="dropdown-item" style="--i:6;--j:5"><a href="./databases.php"></a>Bazy Danych</li>
                <li class="dropdown-item" style="--i:7;--j:4"><a href="./websites.php"></a>Strony Internetowe</li>
                <li class="dropdown-item" style="--i:8;--j:3"><a href="./computer_service.php"></a>Serwis Komputerowy</li>
                <li class="dropdown-item" style="--i:9;--j:2"> <a href="./contact.php"></a>Kontakt</li>
                <?php
                    if($is_admin == 1){
                        echo "<li class='dropdown-item' style='--i:10;--j:1'><a href='../BO/admin_panel.php'></a>Panel Administratora</li>";
                    }
                ?>
            </ol>
        </div>
    </div>
</nav>