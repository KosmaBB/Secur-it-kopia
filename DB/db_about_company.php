<?php
    include_once("db_connection.php");
    class db_about_company extends db_connection {
        function selectAbout_company(){
            $this->databaseConnect();
            mysqli_set_charset($this->connect, "utf8mb4");
            $query = 'SELECT * FROM `about_company` WHERE 1';
            $data = mysqli_query($this->connect, $query);
            if (mysqli_num_rows($data) > 0){
                return $data;
            }
            $this->close();
        }

        function insertAbout_company($title, $description){
            $this->databaseConnect();
            mysqli_set_charset($this->connect, "utf8mb4");
            $query = "INSERT INTO `about_company`(`title`, `description`) VALUES ('".$title."','".$description."');";
            $data = mysqli_query($this->connect, $query);
            if ($data) {
                header('Location: ../BO/admin_about_company.php'); 
            } else {
                echo "Error: " . $query . "<br>" . mysqli_error($this->connect);
            }
            $this->close();
        }

        function deleteAbout_company($id_about_company){
            $this->databaseConnect();
            $query = "Delete from about_company where id_about_company =".$id_about_company.";";
            $data = mysqli_query($this->connect, $query);
            unset($_GET['id_about_company']);
            header('location: ../BO/admin_about_company.php'); 
            $this->close();
        }

        function updateAbout_company($id_about_company, $title, $description){
            $this->databaseConnect();
            mysqli_set_charset($this->connect, "utf8mb4");
            $query = "UPDATE `about_company` SET `title`='".$title."',`description`='".$description."' WHERE `id_about_company`=".$id_about_company.";";
            $data = mysqli_query($this->connect, $query);
            unset($_GET['id_about_company']);
            header('location: ../BO/admin_about_company.php');  
            $this->close();
        }

        function getAbout_companyById($id_about_company){
            $this->databaseConnect();
            mysqli_set_charset($this->connect, "utf8mb4");
            $query = "SELECT * FROM `about_company` WHERE id_about_company = $id_about_company";
            $result = mysqli_query($this->connect, $query);
            return mysqli_fetch_assoc($result);
        }
    }
?>
