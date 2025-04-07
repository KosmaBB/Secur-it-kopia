<?php
    include_once("db_connection.php");
    class db_accounts extends db_connection {
        function selectCustomer($login, $encrypted)
        {
            mysqli_set_charset($this->connect, "utf8mb4");
            $query = "SELECT * FROM `users` AS u 
            LEFT JOIN employees AS e ON u.id_employee = e.id_employee 
            WHERE username='$login' AND password='$encrypted'";
            $data = mysqli_query($this->connect, $query);
            if (mysqli_num_rows($data) > 0)
            {
                return $data;
            }
        }

        function registerCustomer($first_name, $last_name, $username, $password, $id_country_code,  $phone_number, $email_address, $company_name = '', $additional_name = '', $tax = '', $id_company_country_code = '', $company_phone_number = '', $company_email_address = '', $id_company = 'null', $is_company_admin = '0')
        {
            mysqli_set_charset($this->connect, "utf8mb4");
            // Krok 1: Sprawdzenie, czy użytkownik o podanym nicku lub firma o podanej nazwie już istnieją
            $query = "SELECT id_user AS user FROM users WHERE username = '".$username."'";
            if ($company_name != '') {
                $query .= " UNION ";
                $query .= "SELECT id_company AS company FROM companies WHERE company_name = '".$company_name."'";
            }
            $data = mysqli_query($this->connect, $query);

            // Krok 2: Jeśli nie istnieje użytkownik lub firma o podanych danych, przechodzimy do rejestracji
            if (mysqli_num_rows($data) == 0) {
                // Sprawdzenie, czy podano nazwę firmy
                if ($company_name != '') {
                    mysqli_set_charset($this->connect, "utf8mb4");
                    // Rejestracja firmy
                    $query = "INSERT INTO `companies`(`company_name`, `additional_name`, `tax`, `id_country_code`, `phone_number`, `email_address`) VALUES('".$company_name."', '".$additional_name."', '".$tax."', '".$id_company_country_code."', '".$company_phone_number."', '".$company_email_address."')";
                    $data = mysqli_query($this->connect, $query);
                    $id_company = $this->connect->insert_id;

                    if ($data) {
                        // Ustawienie użytkownika jako administratora firmy
                        $is_company_admin = 1;
                    } else {
                        return 2; // Błąd przy tworzeniu firmy. Spróbuj ponownie.
                    }
                }

                mysqli_set_charset($this->connect, "utf8mb4");
                // Krok 3: Rejestracja użytkownika
                $query = "INSERT INTO `users`(`id_company`, `first_name`, `last_name`, `id_country_code`, `phone_number`, `email_address`, `username`, `password`, `is_company_admin`, `id_discount`) VALUES (".$id_company.", '".$first_name."', '".$last_name."', '".$id_country_code."', '".$phone_number."', '".$email_address."', '".$username."', '".$password."', '".$is_company_admin."', null)";
                
                $data = mysqli_query($this->connect, $query);

                if ($data) {
                    $this->close();
                    $_POST = array();
                    return 1; // Rejestracja zakończona sukcesem
                } else {
                    mysqli_rollback($this->connect);
                    return 4; // Użytkownik o takim loginie już istnieje. Wybierz inny login
                }
            } else {
                return 3; // Firma/Użytkownik o takiej nazwie już istnieje. Skontaktuj się z administratorem firmy
            }
        }
    
        function deleteCustomer($id_user)
        {
            $query = "Delete from users where id_user =".$id_user.";";
            $data = mysqli_query($this->connect, $query);
            unset($_GET['id']);
            $this->close();
        }
    
        function updateCustomer($id_user, $id_employee, $id_company, $first_name, $last_name, $id_country_code, $phone_number, $email_address, $username, $password)
        {
            mysqli_set_charset($this->connect, "utf8mb4");
            $query = "UPDATE `users` `id_employee`='".$id_employee."',`id_company`='".$id_company."',`first_name`='".$first_name."',`last_name`='".$last_name."',`id_country_code`='".$id_country_code."',`phone_number`='".$phone_number."',`email_address`='".$email_address."'`username`='".$username."',`password`='".$password."' WHERE `id_user`=".$id_user.";";
            $data = mysqli_query($this->connect, $query);
            unset($_GET['id']);
            header('location: ../index_admin.php');
            $this->close();
        }
    
        function selectCustomerById($id_user, $id_company)
        {
            mysqli_set_charset($this->connect, "utf8mb4");
            $query = "SELECT u.id_user, u.id_company, u.first_name, u.last_name, u.id_country_code as uicc, cc1.country_code as ucc, u.phone_number as upn, u.email_address as uea, u.username, u.password, u.is_company_admin, c.company_name, c.additional_name, c.tax, c.id_country_code, cc2.country_code as ccc, c.phone_number as cpn, c.email_address as cea
            FROM users as u
            JOIN country_codes as cc1 ON cc1.id_country_code = u.id_country_code 
            LEFT JOIN companies as c ON c.id_company = u.id_company
            LEFT JOIN country_codes as cc2 ON cc2.id_country_code = c.id_country_code 
            WHERE id_user =".$id_user.";";

            $data = mysqli_query($this->connect, $query);
            if (mysqli_num_rows($data) > 0) 
            {
                return $data;
            }
        }
        function selectCustomerByIdCompany($id_company)
        {
            mysqli_set_charset($this->connect, "utf8mb4");
            $query = "SELECT u.id_user, u.id_company, u.first_name, u.last_name, cc.country_code as ucc, u.phone_number as upn, u.email_address as uea, u.username, u.password, u.is_company_admin
            FROM users as u
            JOIN country_codes as cc ON cc.id_country_code = u.id_country_code
            WHERE u.id_company =".$id_company;
            $data = mysqli_query($this->connect, $query);
            if (mysqli_num_rows($data) > 0) 
            {
                return $data;
            }
        }

        function updateCustomerPassword($id_user, $new_password)
        {
            mysqli_set_charset($this->connect, "utf8mb4");
            $query = "UPDATE `users` SET `password`='$new_password' WHERE `id_user`=$id_user";
            $data = mysqli_query($this->connect, $query);
            return $data;
        }

        function checkExistingUser($phone_number, $username, $id_user) {
            mysqli_set_charset($this->connect, "utf8mb4");
            $query = "SELECT * FROM `users` WHERE (phone_number='$phone_number' OR username='$username') AND id_user != $id_user";
            $data = mysqli_query($this->connect, $query);
            return mysqli_num_rows($data) > 0;
        }

        function updateUserDetails($id_user, $first_name, $last_name, $phone_number, $email_address, $username) {
            mysqli_set_charset($this->connect, "utf8mb4");
            $query = "UPDATE `users` SET `first_name`='$first_name', `last_name`='$last_name', `phone_number`='$phone_number', `email_address`='$email_address', `username`='$username' WHERE `id_user`=$id_user";
            $data = mysqli_query($this->connect, $query);
            return $data;
        }
    }
?>
