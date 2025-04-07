<?php
    include_once("db_connection.php");
    class db_orders extends db_connection{
        function selectOrderByIdUserWhereInBasket($id_user){
           
            $conn = mysqli_connect("localhost","root","","secur_it");
            mysqli_set_charset($conn, "utf8mb4");
            $query = "SELECT o.id_order, o.order_date, o.order_status, sto.id_service_to_order, sto.amount, s.name, s.price FROM orders AS o
            LEFT JOIN service_to_order AS sto ON sto.id_order = o.id_order
            LEFT JOIN services AS s ON s.id_service = sto.id_service
            WHERE id_user = ".$id_user." AND order_status = 'W koszyku';";
            $data = mysqli_query($this->connect, $query);
            if (mysqli_num_rows($data) > 0){
            return $data;
            }
            else{
                return 0;
            }
        }

        function selectOrderByIdUser($id_user) {
            $conn = mysqli_connect("localhost","root","","secur_it");
            mysqli_set_charset($conn, "utf8mb4");
            $query = "SELECT 
                        o.id_order, 
                        o.order_date, 
                        o.order_status, 
                        GROUP_CONCAT(CONCAT(s.name, ' (', sto.amount, 'x)') SEPARATOR ', ') AS services, 
                        SUM(sto.amount * s.price) AS total_price,
                        SUM(sto.amount) AS total_services
                      FROM orders AS o 
                      LEFT JOIN service_to_order AS sto ON sto.id_order = o.id_order 
                      LEFT JOIN services AS s ON s.id_service = sto.id_service 
                      WHERE id_user = $id_user AND order_status != 'W koszyku' 
                      GROUP BY o.id_order, o.order_date, o.order_status;";
            $data = mysqli_query($this->connect, $query);
            if (mysqli_num_rows($data) > 0){
            return $data;
            }
            else{
                return 0;
            }
        }

        function insertOrder($id_user, $order_date, $order_status, $id_service) {
            $conn = mysqli_connect("localhost","root","","secur_it");
            mysqli_set_charset($conn, "utf8mb4");
            $query = "SELECT id_order FROM orders WHERE id_user = '$id_user' AND order_status = 'W koszyku';";
            $data = mysqli_query($conn, $query);

            if(mysqli_num_rows($data) == 0){
                mysqli_set_charset($conn, "utf8mb4");
                $query = "INSERT INTO `orders`(`id_user`, `order_date`, `order_status`) VALUES ('$id_user', '$order_date', '$order_status');";
                $data = mysqli_query($conn, $query);
                if ($data) {
                    $query = "SELECT id_order FROM orders WHERE id_user = '$id_user' AND order_status = 'W koszyku';";
                    $data = mysqli_query($conn, $query);
                }
            }

            if ($data && mysqli_num_rows($data) > 0) {
                $row = mysqli_fetch_assoc($data);
                $id_order = $row['id_order'];
                mysqli_set_charset($conn, "utf8mb4");
                $query = "SELECT `id_service_to_order`, `id_service`, `id_order`, `amount` FROM `service_to_order` WHERE `id_service` = '$id_service' AND `id_order` = '$id_order';";
                $data = mysqli_query($conn, $query);
                if (mysqli_num_rows($data) > 0) {
                    $row = mysqli_fetch_assoc($data);
                    $id_service_to_order = $row['id_service_to_order'];
                    $amount = $row['amount'] + 1;
                    mysqli_set_charset($conn, "utf8mb4");
                    $query = "UPDATE `service_to_order` SET `amount`='$amount' WHERE `id_service_to_order`='$id_service_to_order';";
                    $data = mysqli_query($conn, $query);
                } else {
                    mysqli_set_charset($conn, "utf8mb4");
                    $query = "INSERT INTO `service_to_order`(`id_service`, `id_order`, `amount`) VALUES ('$id_service', '$id_order', '1');";
                    $data = mysqli_query($conn, $query);
            
                    if ($data) {
                        mysqli_set_charset($conn, "utf8mb4");
                        $query = "INSERT INTO `orders_live`(`id_order`, `id_service`, `order_status`, `change_date`, `id_employee`, `client_description`, `employee_description`) VALUES ('$id_order', '$id_service', '$order_status', '$order_date', NULL, 'Wstawiono do koszyka', NULL);";
                        $data = mysqli_query($conn, $query);
                    } else {
                        die("Błąd podczas dodawania usługi do zamówienia: " . mysqli_error($conn));
                    }
                }
                $this->close();
            } else {
                die("Błąd podczas dodawania zamówienia: " . mysqli_error($conn));
            }
        }
        
        function deleteOrder($id_order, $id_service_to_order){
            unset($_GET['del']);
            
            $query = "DELETE FROM service_to_order WHERE id_service_to_order =".$id_service_to_order.";";
            $data = mysqli_query($this->connect, $query);

            if($data != 0)
            {
                $conn = mysqli_connect("localhost","root","","secur_it");
                mysqli_set_charset($conn, "utf8mb4");
                $query = "SELECT id_service_to_order FROM service_to_order WHERE id_order = $id_order;";
                $data = mysqli_query($this->connect, $query);

                unset($_GET['id_order']);

                if(mysqli_num_rows($data) == 0){
                    $query = "DELETE FROM orders WHERE id_order =".$id_order.";";
                    $data = mysqli_query($this->connect, $query);
                    if ($data) {
                        mysqli_set_charset($conn, "utf8mb4");
                        $query = "INSERT INTO `orders_live`(`id_order`, `id_service`, `order_status`, `change_date`, `id_employee`, `client_description`, `employee_description`) VALUES ('$id_order', NULL, 'Usunięte', '".date('Y-m-d H:i:s')."', NULL, 'Usunięto zamówienie', NULL);";
                        $data = mysqli_query($this->connect, $query);
                    }else{                        
                        die("Błąd podczas usuwania zamówienia: " . mysqli_error($this->connect));
                    }
                }
            }
            else {
                die("Błąd podczas usuwania usługi z koszyka: " . mysqli_error($this->connect));
            }
        }

        function updateOrder($order_date, $order_status, $id_employee){
           
            $conn = mysqli_connect("localhost","root","","secur_it");
            mysqli_set_charset($conn, "utf8mb4");
            $query = "UPDATE `about_company` SET `order_date`='".$order_date."', `order_status`='".$order_status."', `id_employee`='".$id_employee."';";
            $data = mysqli_query($this->connect, $query);
            unset($_GET['id_order']);
            header('location: ./FO/basket.php');  
            $this->close();
        }

        function updateServiceToOrder($id_service_to_order, $amount) {
           
            $conn = mysqli_connect("localhost","root","","secur_it");
            mysqli_set_charset($conn, "utf8mb4");
            $query = "UPDATE service_to_order SET amount='".$amount."' WHERE id_service_to_order='".$id_service_to_order."';";
            $data = mysqli_query($this->connect, $query);
            header('Location: ./FO/basket.php');
            $this->close();
        }

        function updateOrderStatus($id_user, $order_date, $order_status) {
           
            $conn = mysqli_connect("localhost","root","","secur_it");
            mysqli_set_charset($conn, "utf8mb4");
            $query = "SELECT id_order FROM orders WHERE id_user = '$id_user' AND order_status = 'W koszyku';";
            $data = mysqli_query($this->connect, $query);

            if ($data && mysqli_num_rows($data) > 0) {
                $row = mysqli_fetch_assoc($data);
                $id_order = $row['id_order'];
                mysqli_set_charset($conn, "utf8mb4");
                $query = "UPDATE orders SET order_date='$order_date', order_status='$order_status' WHERE id_order='$id_order';";
                $data = mysqli_query($this->connect, $query);

                if ($data) {
                    mysqli_set_charset($conn, "utf8mb4");  
                    $query = "SELECT id_service FROM service_to_order WHERE id_order='$id_order';";
                    $data = mysqli_query($this->connect, $query);

                    while ($row = mysqli_fetch_assoc($data)) {
                        $id_service = $row['id_service'];
                        mysqli_set_charset($conn, "utf8mb4");
                        $query = "INSERT INTO orders_live (id_order, id_service, order_status, change_date, id_employee, client_description, employee_description) VALUES ('$id_order', '$id_service', '$order_status', '$order_date', NULL, 'Zamówienie złożone', NULL);";
                        mysqli_query($this->connect, $query);
                    }
                } else {
                    die("Błąd podczas aktualizacji zamówienia: " . mysqli_error($this->connect));
                }
            } else {
                die("Błąd podczas pobierania zamówienia: " . mysqli_error($this->connect));
            }
            $this->close();
        }

        function updateOrderStatusWithEmployee($id_order, $id_employee, $order_date, $order_status) {
            $conn = mysqli_connect("localhost", "root", "", "secur_it");
            mysqli_set_charset($conn, "utf8mb4");

            $query = "UPDATE orders 
                      SET order_status = '$order_status', order_date = '$order_date', id_employee = '$id_employee' 
                      WHERE id_order = '$id_order';";
            $data = mysqli_query($conn, $query);

            if ($data) {
                $query = "INSERT INTO orders_live (id_order, id_service, order_status, change_date, id_employee, client_description, employee_description) 
                          VALUES ('$id_order', NULL, '$order_status', '$order_date', '$id_employee', 'Przypisano pracownika', NULL);";
                mysqli_query($conn, $query);
            } else {
                die("Błąd podczas aktualizacji zamówienia: " . mysqli_error($conn));
            }

            mysqli_close($conn);
        }

        function releaseOrder($id_order, $order_date) {
            $conn = mysqli_connect("localhost", "root", "", "secur_it");
            mysqli_set_charset($conn, "utf8mb4");

            $query = "UPDATE orders 
                      SET order_status = 'Oczekujące', id_employee = NULL, order_date = '$order_date' 
                      WHERE id_order = '$id_order';";
            $data = mysqli_query($conn, $query);

            if ($data) {
                $query = "INSERT INTO orders_live (id_order, id_service, order_status, change_date, id_employee, client_description, employee_description) 
                          VALUES ('$id_order', NULL, 'Oczekujące', '$order_date', NULL, 'Zamówienie zwolnione', NULL);";
                mysqli_query($conn, $query);
            } else {
                die("Błąd podczas zwalniania zamówienia: " . mysqli_error($conn));
            }

            mysqli_close($conn);
        }

        function getAllOrders() {
            $conn = mysqli_connect("localhost", "root", "", "secur_it");
            mysqli_set_charset($conn, "utf8mb4");

            $query = "SELECT 
                        o.id_order, 
                        o.order_date, 
                        o.order_status, 
                        GROUP_CONCAT(CONCAT(s.name, ' (', sto.amount, 'x)') SEPARATOR ', ') AS services, 
                        SUM(sto.amount * s.price) AS total_price,
                        o.id_employee,
                        CONCAT(u.first_name, ' ', u.last_name) AS employee_name
                      FROM orders AS o
                      LEFT JOIN service_to_order AS sto ON sto.id_order = o.id_order
                      LEFT JOIN services AS s ON s.id_service = sto.id_service
                      LEFT JOIN users AS u ON u.id_employee = o.id_employee
                      GROUP BY o.id_order, o.order_date, o.order_status, o.id_employee;";
            $data = mysqli_query($conn, $query);

            if ($data) {
                return $data;
            } else {
                die("Błąd podczas pobierania zamówień: " . mysqli_error($conn));
            }
        }

        function getOrdersByEmployee($id_employee) {
            $conn = mysqli_connect("localhost", "root", "", "secur_it");
            mysqli_set_charset($conn, "utf8mb4");

            $query = "SELECT 
                        o.id_order, 
                        o.order_date, 
                        o.order_status, 
                        GROUP_CONCAT(CONCAT(s.name, ' (', sto.amount, 'x)') SEPARATOR ', ') AS services, 
                        SUM(sto.amount * s.price) AS total_price
                      FROM orders AS o
                      LEFT JOIN service_to_order AS sto ON sto.id_order = o.id_order
                      LEFT JOIN services AS s ON s.id_service = sto.id_service
                      WHERE o.id_employee = '$id_employee'
                      GROUP BY o.id_order, o.order_date, o.order_status;";
            $data = mysqli_query($conn, $query);

            if ($data) {
                return $data;
            } else {
                die("Błąd podczas pobierania zamówień: " . mysqli_error($conn));
            }
        }

        function getAllOrdersExcludingCompleted() {
            $conn = mysqli_connect("localhost", "root", "", "secur_it");
            mysqli_set_charset($conn, "utf8mb4");

            $query = "SELECT 
                        o.id_order, 
                        o.order_date, 
                        o.order_status, 
                        GROUP_CONCAT(CONCAT(s.name, ' (', sto.amount, 'x)') SEPARATOR ', ') AS services, 
                        SUM(sto.amount * s.price) AS total_price,
                        o.id_employee,
                        CONCAT(u.first_name, ' ', u.last_name) AS employee_name
                      FROM orders AS o
                      LEFT JOIN service_to_order AS sto ON sto.id_order = o.id_order
                      LEFT JOIN services AS s ON s.id_service = sto.id_service
                      LEFT JOIN users AS u ON u.id_employee = o.id_employee
                      WHERE o.order_status != 'Zrealizowane'
                      GROUP BY o.id_order, o.order_date, o.order_status, o.id_employee;";
            $data = mysqli_query($conn, $query);

            if ($data) {
                return $data;
            } else {
                die("Błąd podczas pobierania zamówień: " . mysqli_error($conn));
            }
        }

        function getCompletedOrders() {
            $conn = mysqli_connect("localhost", "root", "", "secur_it");
            mysqli_set_charset($conn, "utf8mb4");

            $query = "SELECT 
                        o.id_order, 
                        o.order_date, 
                        o.order_status, 
                        GROUP_CONCAT(CONCAT(s.name, ' (', sto.amount, 'x)') SEPARATOR ', ') AS services, 
                        SUM(sto.amount * s.price) AS total_price
                      FROM orders AS o
                      LEFT JOIN service_to_order AS sto ON sto.id_order = o.id_order
                      LEFT JOIN services AS s ON s.id_service = sto.id_service
                      WHERE o.order_status = 'Zrealizowane'
                      GROUP BY o.id_order, o.order_date, o.order_status;";
            $data = mysqli_query($conn, $query);

            if ($data) {
                return $data;
            } else {
                die("Błąd podczas pobierania zrealizowanych zamówień: " . mysqli_error($conn));
            }
        }
    }
?>
