<?php
include_once("../DB/db_orders.php");
include_once("../include/functions.php");

$dbOrders = new db_orders();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['assign'])) {
    $id_order = $_POST['id_order'];
    $id_employee = $_SESSION['id_employee']; // Ensure this is set in the session
    $order_date = date('Y-m-d H:i:s');
    $order_status = 'W trakcie';

    if ($id_employee) {
        $dbOrders->updateOrderStatusWithEmployee($id_order, $id_employee, $order_date, $order_status);
        header("Location: orders.php");
        exit();
    } else {
        echo "<p class='error-message'>Błąd: Nie można przypisać zamówienia bez zalogowanego pracownika.</p>";
    }
}

$orders = $dbOrders->getAllOrdersExcludingCompleted();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zamówienia</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <?php
        include("./admin_header.php");
        include("./admin_nav.php");
        include("../DB/db_contact.php");
    ?>
    <div class="main">
        <div class="orders-header">
            <h1 class="center-text">Zamówienia Klientów</h1>
            <div class="button-container center-content">
                <a href="my_orders.php" class="button normal-size">Moje Zamówienia</a>
                <a href="completed_orders.php" class="button normal-size">Zrealizowane Zamówienia</a>
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
                                    <?php if (!empty($order['id_employee'])): ?>
                                        <span class="success-message assigned-text">Przypisano do <?= $order['employee_name'] ?></span>
                                    <?php else: ?>
                                        <form method="POST">
                                            <input type="hidden" name="id_order" value="<?= $order['id_order'] ?>">
                                            <button type="submit" name="assign" class="modern-button">Przypisz</button>
                                        </form>
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
        <div class="button-container center-content">
            <a href="admin_panel.php" class="button back-button">Powrót</a>
        </div>
    </div>
</body>
</html>
