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
        <title>Secur IT | Home</title>
    </head>
    <body>
        <div class="tlo"></div>
        <main class="main">
            <?php
                include("header.php");
                include("nav.php");
                include("footer.php");
            ?>
            <div class="algorithm-flow">
                <div class="algorithm-box" 
                     data-title="Witaj w Secur-IT!" 
                     data-icon="fa-solid fa-handshake" 
                     data-content="W dzisiejszym cyfrowym świecie niezawodność i bezpieczeństwo IT to fundament każdej firmy."></div>
                     
                <div class="algorithm-box" 
                     data-title="Nasza Misja" 
                     data-icon="fa-solid fa-bullseye" 
                     data-content="Tworzymy stabilne i bezpieczne środowiska IT, które wspierają rozwój firm."></div>
                     
                <div class="algorithm-box" 
                     data-title="Co Oferujemy" 
                     data-icon="fa-solid fa-list-check" 
                     data-content="<ul><li>Serwis</li><li>Budowa sieci</li><li>Tworzenie stron</li><li>Administracja systemami</li><li>Bazy danych</li></ul>"></div>
                     
                <div class="algorithm-box" 
                     data-title="Dlaczego Secur-IT?" 
                     data-icon="fa-solid fa-star" 
                     data-content="<ul><li>Doświadczenie</li><li>Bezpieczeństwo</li><li>Indywidualne podejście</li>"></div>
            </div>
        </main>
    </body>
</html>