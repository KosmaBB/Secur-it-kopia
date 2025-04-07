<?php
    include_once("db_connection.php");
    class db_contact extends db_connection {
        function selectContact(){
            mysqli_set_charset($this->connect, "utf8mb4");
            $query = 'SELECT cf.*, u.first_name AS ufn, u.last_name AS uln, cc.country_code FROM `contact_form` AS cf
            LEFT JOIN users AS u ON u.id_employee = cf.id_employee
            JOIN country_codes AS cc ON cc.id_country_code = cf.id_country_code
            WHERE 1;';
            $data = mysqli_query($this->connect, $query);
            if (mysqli_num_rows($data) > 0){
                return $data;
            }
        }

        function insertContact ($first_name, $last_name, $email, $id_country_code, $phone_number, $title, $message, $consent){
            mysqli_set_charset($this->connect, "utf8mb4");
            $id_user = $_SESSION['id_user'];
            $query = "INSERT INTO `contact_form` (`id_user`,`first_name`, `last_name`, `email`, `id_country_code`, `phone_number`, `title`, `message`, `consent`, `status`) VALUES ('".$id_user."','".$first_name."','".$last_name."','".$email."','".$id_country_code."','".$phone_number."','".$title."','".$message."','".$consent."','Wysłano');";
            $data = mysqli_query($this->connect, $query);
            if ($data) {
                $id_contact_form = $this->connect->insert_id;
                $date = date("Y-m-d H:i:s");
                $id_user = $_SESSION['id_user'];
                $query = "INSERT INTO `task_history`(`id_contact_form`, `id_user`, `title`, `message`, `date`, `description`, `status`) VALUES  ('".$id_contact_form."','".$id_user."','".$title."','".$message."','".$date."','Utworzono zadanie','Wysłano');";
                $data = mysqli_query($this->connect, $query);
                if ($data) {
                    $this->close();
                    $$_GET = array();
                    return 1; // Wiadomosc wysłana
                }
            }
        }

        function deleteContact($id_contact_form){
            mysqli_set_charset($this->connect, "utf8mb4");
            // Delete the contact form entry
            $query = "DELETE FROM `contact_form` WHERE `id_contact_form` = ".$id_contact_form.";";

            $data = mysqli_query($this->connect, $query);
            $this->wQueryToFile($query);
            if (!$data) {
                throw new Exception("Failed to delete contact form: " . mysqli_error($this->connect));
            }

            // Log the deletion in the task_history table
            $date = date("Y-m-d H:i:s");
            $id_user = $_SESSION['id_user'];
            $query = "INSERT INTO `task_history`(`id_contact_form`, `id_user`, `date`, `description`, `status`) VALUES ('".$id_contact_form."', '".$id_user."', '".$date."', 'Zadanie zostało usunięte', 'Usunięte');";
            $this->wQueryToFile($query);
            $data = mysqli_query($this->connect, $query);
            if (!$data) {
                throw new Exception("Failed to log task deletion: " . mysqli_error($this->connect));
            }
        }
        
        function updateContactMessage($id_contact_form, $title, $message, $status) {
            mysqli_set_charset($this->connect, "utf8mb4");
            $query = "UPDATE `contact_form` SET `message`='".$message."' WHERE `id_contact_form`=".$id_contact_form.";";
            $data = mysqli_query($this->connect, $query);
            if ($data) {
                $date = date("Y-m-d H:i:s");
                $id_user = $_SESSION['id_user'];
                $query = "INSERT INTO `task_history`(`id_contact_form`, `id_user`, `title`, `message`, `date`, `description`, `status`) VALUES ('".$id_contact_form."','".$id_user."','".$title."','".$message."','".$date."','Zaktualizowano zadanie','".$status."');";
                $data = mysqli_query($this->connect, $query);
            }
            unset($_GET['id_contact_form']); 
            $this->close();
        }

        function selectContactByID($id_contact_form){
            mysqli_set_charset($this->connect, "utf8mb4");
            $query = "SELECT cf.*, 
                     u.first_name AS employee_first_name, 
                     u.last_name AS employee_last_name, 
                     cc.country_code,
                     th.status AS th_status, th.description
              FROM `contact_form` AS cf
              LEFT JOIN users AS u ON u.id_employee = cf.id_employee
              LEFT JOIN country_codes AS cc ON cc.id_country_code = cf.id_country_code
              LEFT JOIN (
                  SELECT id_contact_form, status, description, ROW_NUMBER() OVER (PARTITION BY id_contact_form ORDER BY date DESC) AS rn
                  FROM task_history
              ) AS th ON th.id_contact_form = cf.id_contact_form AND th.rn = 1
              WHERE cf.id_contact_form = ".$id_contact_form;
            $data = mysqli_query($this->connect, $query);

            if ($data && mysqli_num_rows($data) > 0) {
                return mysqli_fetch_assoc($data); // Return a single row as an associative array
            }
            return null; // Return null if no data is found
        }

        function updateContactSetEmployee($id_contact_form, $id_employee){
            mysqli_set_charset($this->connect, "utf8mb4");
            $query = "UPDATE `contact_form` SET `status`='Przyjęto', `id_employee`=".$id_employee." WHERE  `id_contact_form`=".$id_contact_form.";";  
            $data = mysqli_query($this->connect, $query);
            if ($data) {
                $query = "SELECT * FROM `contact_form` WHERE id_contact_form =".$id_contact_form.";";
                $data = mysqli_query($this->connect, $query);

                if ($data && mysqli_num_rows($data) > 0) {
                    $row = mysqli_fetch_assoc($data);
                    $title = $row['title'];
                    $message = $row['message'];

                    if($data){
                        $date = date("Y-m-d H:i:s");
                        $id_user = $_SESSION['id_user'];
                        mysqli_set_charset($this->connect, "utf8mb4");
                        $query = "INSERT INTO `task_history`(`id_contact_form`, `id_employee`, `id_user`, `title`, `message`, `date`, `description`, `status`) VALUES ('".$id_contact_form."','".$id_employee."','".$id_user."','".$title."','".$message."','".$date."','Pracownik przyjął zadanie','Przyjęto');";
                        $data = mysqli_query($this->connect, $query);
                    }
                }
            }
            unset($_GET['id_contact_form']); 
            $this->close();
        }

        function updateContactSetStatus($id_contact_form, $status, $id_employee){
            mysqli_set_charset($this->connect, "utf8mb4");
            $query = "SELECT * FROM `contact_form` WHERE id_contact_form =".$id_contact_form.";";
            $data = mysqli_query($this->connect, $query);
            $this->wQueryToFile($query);
            $row = mysqli_fetch_assoc($data);
            $id_employee = NULL;
            if ($data && mysqli_num_rows($data) > 0) {
                $row = mysqli_fetch_assoc($data);
                $query = "UPDATE `contact_form` SET `status`='".$status."', `id_employee`='".$id_employee."' WHERE `id_contact_form`=".$id_contact_form.";";
                $this->wQueryToFile($query);
                $data = mysqli_query($this->connect, $query);
                if (!$data) {
                    throw new Exception("Failed to update contact status: " . mysqli_error($this->connect));
                }
            }
        }

        function insertTaskHistory($id_contact_form, $id_employee, $description, $status){
            mysqli_set_charset($this->connect, "utf8mb4");
            $query = "SELECT * FROM `contact_form` WHERE id_contact_form =".$id_contact_form.";";
            $data = mysqli_query($this->connect, $query);

            if ($data && mysqli_num_rows($data) > 0) {
                $row = mysqli_fetch_assoc($data);
                $title = $row['title'];
                $message = $row['message'];
                $date = date("Y-m-d H:i:s");
                $id_employee = $row['id_employee'];
                $id_user = $_SESSION['id_user'];
                $query = "INSERT INTO `task_history`(`id_contact_form`, `id_employee`, `id_user`, `title`, `message`, `date`, `description`, `status`) 
                          VALUES ('".$id_contact_form."','".$id_employee."','".$id_user."','".$title."','".$message."','".$date."','".$description."','".$status."');";
                          $this->wQueryToFile($query);
                $data = mysqli_query($this->connect, $query);
                if (!$data) {
                    throw new Exception("Failed to insert task history: " . mysqli_error($this->connect));
                }
            } else {
                throw new Exception("No contact form found with id: " . $id_contact_form);
            }
        }

        function selectContactByIdUser($id_user) {
            mysqli_set_charset($this->connect, "utf8mb4");
            $query = "SELECT cf.*, cc.country_code, th.description, cf.id_employee AS th_status FROM `contact_form` AS cf
            JOIN country_codes AS cc ON cc.id_country_code = cf.id_country_code
            LEFT JOIN (
                SELECT id_contact_form, description, status, ROW_NUMBER() OVER (PARTITION BY id_contact_form ORDER BY date DESC) AS rn
                FROM task_history
                WHERE status='Oczekuje potwierdzenia' OR status='Wolne'
            ) AS th ON th.id_contact_form = cf.id_contact_form AND th.rn = 1
            WHERE cf.id_user='".$id_user."';";
            $data = mysqli_query($this->connect, $query);
            if (mysqli_num_rows($data) > 0){
                return $data;
            }
            $this->close();
        }

        function selectTasksByEmployee($id_employee) {
            mysqli_set_charset($this->connect, "utf8mb4");
            $query = "SELECT cf.*, cc.country_code, th.description, th.status AS th_status FROM `contact_form` AS cf
            JOIN country_codes AS cc ON cc.id_country_code = cf.id_country_code
            LEFT JOIN (
                SELECT id_contact_form, description, status, ROW_NUMBER() OVER (PARTITION BY id_contact_form ORDER BY date DESC) AS rn
                FROM task_history
                WHERE status='Oczekuje potwierdzenia' OR status='Wolne'
            ) th ON th.id_contact_form = cf.id_contact_form AND th.rn = 1
            WHERE cf.id_employee='".$id_employee."';";
            $data = mysqli_query($this->connect, $query);
            if (mysqli_num_rows($data) > 0){
                return $data;
            }
            $this->close();
        }

        function updateContactSetEmployeeToNull($id_contact_form) {
            mysqli_set_charset($this->connect, "utf8mb4");
            $query = "UPDATE `contact_form` SET `id_employee`=NULL, `status`='Wolne' WHERE `id_contact_form`=".$id_contact_form.";";
            $data = mysqli_query($this->connect, $query);
            if ($data) {
                $date = date("Y-m-d H:i:s");
                $id_user = $_SESSION['id_user'];
                $query = "INSERT INTO `task_history`(`id_contact_form`, `id_user`, `date`, `description`, `status`) VALUES ('".$id_contact_form."', '".$id_user."', '".$date."', 'Zadanie zostało zwolnione', 'Wolne');";
                mysqli_query($this->connect, $query);
            }
            $this->close();
        }
    }
?>