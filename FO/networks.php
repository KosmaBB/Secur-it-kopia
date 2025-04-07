<?php
    include_once('../include/functions.php');
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
        <title>Secur IT | Usługi - Sieci Komputerowe</title>
    </head>
    <body>
        <div class="tlo"></div>
        <main class="main">
            <?php
                include("header.php");
                include("nav.php");
                include("footer.php");
            ?>
            <?php
                include('../DB/db_services.php');
                $baza = new db_services();
                $baza->databaseConnect();
                $data = $baza->selectServices_networks();

                if (!empty($data)) {
            ?>
            <div class="tresc">
            <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['opcja']) && $_POST['opcja'] === 'dodaj') {
                    include_once("../DB/db_orders.php");

                    $order_date = date("Y-m-d H:i:s");
                    $order_status = "W koszyku";
                    $id_service = $_POST['id_service'];

                    $baza_orders = new db_orders();
                    $baza_orders->insertOrder($id_user, $order_date, $order_status, $id_service);
                    
                    unset($_POST['opcja']);
                }

                while ($row = mysqli_fetch_assoc($data)) {
                    echo "<div class='artykul'>
                    <h3>".$row['name']."</h3>
                    <p>".$row['description']."</p>
                    <div class='price'>".$row['price']."</div>";

                    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                        echo "<form method='POST' action='networks.php'>
                            <input type='hidden' name='id_service' value='".$row['id_service']."'>
                            <button type='submit' name='opcja' value='dodaj'>Dodaj do koszyka</button>
                        </form>";
                    }
                    echo "</div>";
                }
                } else {
                    echo "Brak usług";
                }
                $baza->close();
            ?>
            </div>
        </main>
    </body>
</html>