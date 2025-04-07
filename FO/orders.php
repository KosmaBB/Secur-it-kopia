<?php
    include_once ('../include/functions.php');
    include_once ('../DB/db_orders.php');
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
        <title>Secur IT | Zamówienia</title>
    </head>
    <body>
        <div class="tlo"></div>
        <main class="main">
            <?php
                include("header.php");
                include("nav.php");
                include("footer.php");
            ?>
            <div class="zamowienia">
                <?php
                    $baza = new db_orders;
                    $baza->databaseConnect();

                    $data = $baza->selectOrderByIdUser($id_user);

                    if (!empty($data)) {
                        echo "<div class='zamowienie'>";
                        while ($row = mysqli_fetch_assoc($data)) {
                            echo "<div class='koszyk-item'>
                                    <p>Data zamówienia: " . $row['order_date'] . "</p>
                                    <p>Status: " . $row['order_status'] . "</p>
                                    <p>Usługi: " . $row['services'] . "</p>
                                    <p>Kwota: " . number_format($row['total_price'], 2) . " PLN</p>
                                  </div>";
                        }
                        echo "</div>";
                    }
                    $baza->close();
                ?>
            </div>
        </main>
    </body>
</html>