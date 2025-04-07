<?php
include_once("../DB/db_orders.php");
include_once("../include/functions.php");

session_start();
if (!isset($_SESSION['id_employee'])) {
    header("Location: login.php");
    exit();
}

$dbOrders = new db_orders();
$id_employee = $_SESSION['id_employee'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_order = $_POST['id_order'];
    $order_date = date('Y-m-d H:i:s');

    if (isset($_POST['complete'])) {
        $order_status = 'Zrealizowane';
        $dbOrders->updateOrderStatusWithEmployee($id_order, $id_employee, $order_date, $order_status);
    } elseif (isset($_POST['release'])) {
        $order_status = 'Oczekujące';
        $dbOrders->releaseOrder($id_order, $order_date);
    }

    header("Location: my_orders.php");
    exit();
}

$orders = $dbOrders->getOrdersByEmployee($id_employee);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moje Zamówienia</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <?php include("./admin_header.php"); ?>
    <div class="main">
        <div class="orders-header">
            <h1 class="center-text">Moje Zamówienia</h1>
            <div class="button-container center-content">
                <a href="orders.php" class="button normal-size">Powrót</a>
            </div>
        </div>
        <div class="orders-container" style="background-color: rgba(255, 255, 255, 0.9);">
            <?php if ($orders && mysqli_num_rows($orders) > 0): ?>
                <table class="kontakt_table">
                    <thead>
                        <tr>
                            <th>ID Zamówienia</th>
                            <th>Data</th>
                            <th>Status</th>
                            <th>Usługi</th>
                            <th>Łączna Cena</th>
                            <th>Akcja</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($order = mysqli_fetch_assoc($orders)): ?>
                            <tr>
                                <td><?= $order['id_order'] ?></td>
                                <td><?= $order['order_date'] ?></td>
                                <td><?= $order['order_status'] ?></td>
                                <td><?= $order['services'] ?></td>
                                <td><?= number_format($order['total_price'], 2) ?> PLN</td>
                                <td>
                                    <?php if ($order['order_status'] !== 'Zrealizowane'): ?>
                                        <form method="POST">
                                            <input type="hidden" name="id_order" value="<?= $order['id_order'] ?>">
                                            <button type="submit" name="complete" class="modern-button">Zakończ</button>
                                            <button type="submit" name="release" class="modern-button release-button">Zwolnij</button>
                                        </form>
                                    <?php else: ?>
                                        <span class="success-message assigned-text">Zrealizowane</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="empty-message">Brak zamówień do wyświetlenia.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
