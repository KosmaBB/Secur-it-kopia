<?php
include_once('../include/functions.php');
include_once('../DB/db_orders.php');

if (isset($_GET['id_service_to_order']) && isset($_GET['amount'])) {
    $id_service_to_order = $_GET['id_service_to_order'];
    $amount = $_GET['amount'];

    $baza = new db_orders();
    $baza->databaseConnect();
    $baza->updateServiceToOrder($id_service_to_order, $amount);
    $baza->close();

    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid parameters']);
}
?>
