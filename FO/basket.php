<?php
    include_once ('../include/functions.php');
    include_once("../DB/db_orders.php");
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
        <title>Secur IT | Koszyk</title>
    </head>
    <body>
        <div class="tlo"></div>
        <main class="main">
            <?php
                include("nav.php");
            ?>
            <div class="basket-container">
                <h2>Twój Koszyk</h2>
                <a href="./orders.php" class="button">Moje zamówienia</a>
                <br><br>
                <div class="basket-content">
                    <div class="koszyk">
                    <?php
                        $baza = new db_orders;
                        $baza->databaseConnect();
                        if(isset($_GET['del']))
                        {
                            $id_order=$_GET['id_order'];
                            $id_service_to_order=$_GET['id_service_to_order'];
                            $baza->deleteOrder($id_order, $id_service_to_order);
                        }
                        if(isset($_POST['place_order'])) {
                            $order_date = date('Y-m-d H:i:s');
                            $order_status = 'Oczekujące';
                            $baza->updateOrderStatus($id_user, $order_date, $order_status);
                        }
                        $data = $baza->selectOrderByIdUserWhereInBasket($id_user);
                        if ($data && mysqli_num_rows($data) > 0) {
                            while ($row = mysqli_fetch_assoc($data)) {
                                $selected = $row['amount'];
                                $isOther = $selected > 9 ? ' selected' : '';
                                echo "<div class='koszyk-item'>
                                        <p class='item-name'>Nazwa usługi: ".$row['name']."</p>
                                        <p class='item-quantity'>Ilość:
                                            <select class='item-quantity-select' id='item-quantity' data-id=".$row['id_service_to_order']." data-price=".$row['price']." name='amount'>
                                                <option value='1'".($selected == 1 ? ' selected' : '').">1</option>
                                                <option value='2'".($selected == 2 ? ' selected' : '').">2</option>
                                                <option value='3'".($selected == 3 ? ' selected' : '').">3</option>
                                                <option value='4'".($selected == 4 ? ' selected' : '').">4</option>
                                                <option value='5'".($selected == 5 ? ' selected' : '').">5</option>
                                                <option value='6'".($selected == 6 ? ' selected' : '').">6</option>
                                                <option value='7'".($selected == 7 ? ' selected' : '').">7</option>
                                                <option value='8'".($selected == 8 ? ' selected' : '').">8</option>
                                                <option value='9'".($selected == 9 ? ' selected' : '').">9</option>
                                                <option value='other'".$isOther.">Inna</option>
                                            </select>
                                            <input type='number' class='item-quantity-input' id='item-quantity-input' data-id=".$row['id_service_to_order']." data-price=".$row['price']." name='amount' style='".($isOther ? 'display:inline-block;' : 'display:none;')."' min='1' value='".$selected."'>
                                        </p>
                                        <p class='item-price'>Cena jednostkowa: ".$row['price']." zł</p>
                                        <p class='item-total-price'>Cena zbiorcza: <span class='product-total-price'>".($row['price'] * $selected)."</span> zł</p>
                                        <button class='button delete'>
                                            <a href=basket.php?del=True&id_order=".$row['id_order']."&id_service_to_order=".$row['id_service_to_order'].">
                                                Usuń usługę
                                            </a>
                                        </button>
                                    </div>";
                            }
                            echo "<div class='final-price-container'>
                                    <p class='final-price'>Cena końcowa: <span id='finalPrice'>0.00</span> zł</p>
                                    <form method='post' action='basket.php'>
                                        <button type='submit' name='place_order' class='button'>Zamów</button>
                                    </form>
                                  </div>";
                        } else {
                            echo "<p class='empty-basket'>Koszyk jest pusty</p>";
                        }
                    ?>
                    </div>
                </div>
            </div>
            <?php
                include("footer.php");
            ?>
        </main>
    </body>
</html>