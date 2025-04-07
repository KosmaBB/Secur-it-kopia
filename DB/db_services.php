<?php
    include_once("db_connection.php");
    class db_services extends db_connection{

        function SelectServiceType(){            
            mysqli_set_charset($this->connect, "utf8mb4");
            $query = 'SELECT * FROM `service_types` WHERE 1';
            $data = mysqli_query($this->connect, $query);
            if (mysqli_num_rows($data) > 0) {
                return $data;
            }
        }

        function selectServiceById($id_service) {
            mysqli_set_charset($this->connect, "utf8mb4");
            $query = "SELECT `id_service`, `id_service_type`, `name`, `description`, `price` FROM `services` WHERE id_service =".$id_service;
            $data = mysqli_query($this->connect, $query);
            if (mysqli_num_rows($data) > 0) {
                return $data;
            }
        }
        function selectServices_networks(){
            mysqli_set_charset($this->connect, "utf8mb4");
            $query = 'SELECT * FROM `services` WHERE id_service_type = 1';
            $data = mysqli_query($this->connect, $query);
            if (mysqli_num_rows($data) > 0){
                return $data;
            }
        }
        
        function selectServices_systems(){
            mysqli_set_charset($this->connect, "utf8mb4");
            $query = 'SELECT * FROM `services` WHERE id_service_type = 2';
            $data = mysqli_query($this->connect, $query);
            if (mysqli_num_rows($data) > 0){
            return $data;
            }
        }

        function selectServices_databases(){
            mysqli_set_charset($this->connect, "utf8mb4");

            $query = 'SELECT * FROM `services` WHERE id_service_type = 3';
            $data = mysqli_query($this->connect, $query);
            if (mysqli_num_rows($data) > 0){
            return $data;
            }
        }

        function selectServices_websites(){
            mysqli_set_charset($this->connect, "utf8mb4");

            $query = 'SELECT * FROM `services` WHERE id_service_type = 4';
            $data = mysqli_query($this->connect, $query);
            if (mysqli_num_rows($data) > 0){
            return $data;
            }
        }

        function selectServices_computer_service(){
            mysqli_set_charset($this->connect, "utf8mb4");

            $query = 'SELECT * FROM `services` WHERE id_service_type = 5';
            $data = mysqli_query($this->connect, $query);
            if (mysqli_num_rows($data) > 0){
            return $data;
            }
        }

        function insertServices ($id_service_type, $name, $description, $price){
            mysqli_set_charset($this->connect, "utf8mb4");
            $query = "INSERT INTO `services`(`id_service_type`, `name`, `description`, `price`) VALUES ('".$id_service_type."', '".$name."','".$description."','".$price."');";
            $data = mysqli_query($this->connect, $query);
            header('location: ../BO/uslugi.php'); 
            $this->close();
        }

        function deleteServices ($id_service){
            $query = "Delete from services where id_service =".$id_service.";";
            $data = mysqli_query($this->connect, $query);
            unset($_GET['id_service']);
            header('location: ../BO/uslugi.php'); 
            $this->close();
        }

        function updateServices ($id_service, $name, $description, $price){
            mysqli_set_charset($this->connect, "utf8mb4");
            $query = "UPDATE `services` SET `name`='".$name."',`description`='".$description."',`price`='".$price."' WHERE `id_service`=".$id_service.";";
            $data = mysqli_query($this->connect, $query);
            unset($_GET['id_service']);
            header('location: ../BO/services.php');  
            $this->close();
        }
    }
?>
