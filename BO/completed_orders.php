<?php
include_once("../DB/db_orders.php");
include_once("../include/functions.php");

$dbOrders = new db_orders();
$completedOrders = $dbOrders->getCompletedOrders();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zrealizowane Zamówienia</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <?php include("./admin_header.php"); ?>
    <div class="main">
        <div class="orders-header">
            <h1 class="center-text">Zrealizowane Zamówienia</h1>
            <div class="button-container center-content">
                <a href="orders.php" class="button normal-size">Powrót</a>
            </div>
        </div>
        <div class="orders-container" style="background-color: rgba(255, 255, 255, 0.9);">
            <?php if ($completedOrders && mysqli_num_rows($completedOrders) > 0): ?>
                <table class="kontakt_table">
                    <thead>
                        <tr>
                            <th>ID Zamówienia</th>
                            <th>Data</th>
                            <th>Status</th>
                            <th>Usługi</th>
                            <th>Łączna Cena</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($order = mysqli_fetch_assoc($completedOrders)): ?>
                            <tr>
                                <td><?= $order['id_order'] ?></td>
                                <td><?= $order['order_date'] ?></td>
                                <td><?= $order['order_status'] ?></td>
                                <td><?= $order['services'] ?></td>
                                <td><?= number_format($order['total_price'], 2) ?> PLN</td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="empty-message">Brak zrealizowanych zamówień do wyświetlenia.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
