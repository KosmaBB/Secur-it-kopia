<?php    
    include_once("db_connection.php");
    class db_employees extends db_connection{
        function selectEmployeeById($id_employee){
            mysqli_set_charset($this->connect, "utf8mb4");
            $query = "SELECT u.first_name, u.last_name, u.id_country_code, cc.country_code, u.phone_number, u.email_address, e.home_address, e.date_of_birth, e.photo, c.*, ct.*, p.name, d.department_name
            FROM `users` AS u
            LEFT JOIN country_codes AS cc ON u.id_country_code = cc.id_country_code
            LEFT JOIN employees AS e ON u.id_employee = e.id_employee
            LEFT JOIN contracts AS c ON e.id_contract = c.id_contract
            LEFT JOIN contracts_types AS ct ON c.id_contract_type = ct.id_contract_type
            LEFT JOIN locations AS l ON c.id_work_location = l.id_location
            LEFT JOIN positions AS p ON e.id_position = p.id_position
            LEFT JOIN departments AS d ON c.id_department = d.id_department
            WHERE u.id_employee = ".$id_employee;
            $data = mysqli_query($this->connect, $query);
            
            if (mysqli_num_rows($data) > 0) {
                return $data;
            }
        }
        function selectEmployee(){
            mysqli_set_charset($this->connect, "utf8mb4");
            $query = 'SELECT u.id_employee, u.first_name, u.last_name, e.photo, p.name, d.department_name 
            FROM users AS u
            JOIN employees as e ON u.id_employee = e.id_employee
            JOIN positions AS p ON e.id_position = p.id_position 
            JOIN contracts as c ON e.id_contract = c.id_contract
            left JOIN departments AS d ON c.id_department = d.id_department';

            $data = mysqli_query($this->connect, $query);
            if (mysqli_num_rows($data) > 0){
            return $data;
            }
        }
        function selectEmployeesAll(){
            mysqli_set_charset($this->connect, "utf8mb4");
            $query = 'SELECT * FROM `employees`;';
            $data = mysqli_query($this->connect, $query);
            if (mysqli_num_rows($data) > 0){
            return $data;
            }
        }

        function SelectPositions(){
            mysqli_set_charset($this->connect, "utf8mb4");
            $query = 'SELECT * FROM `positions` WHERE id_position > 2';
            $data = mysqli_query($this->connect, $query);
            if (mysqli_num_rows($data) > 0) {
                return $data;
            }
        }

        function SelectWorkLocations(){
            mysqli_set_charset($this->connect, "utf8mb4");
            $query = 'SELECT * FROM `locations` WHERE 1';
            $data = mysqli_query($this->connect, $query);
            if (mysqli_num_rows($data) > 0) {
                return $data;
            }
        }

        function SelectDepartments(){
            mysqli_set_charset($this->connect, "utf8mb4");
            $query = 'SELECT * FROM `departments` WHERE 1';
            $data = mysqli_query($this->connect, $query);
            if (mysqli_num_rows($data) > 0) {
                return $data;
            }
        }

        function SelectCars(){
            mysqli_set_charset($this->connect, "utf8mb4");
            $query = 'SELECT * FROM `cars` WHERE 1';
            $data = mysqli_query($this->connect, $query);
            if (mysqli_num_rows($data) > 0) {
                return $data;
            }
        }

        function SelectContractsTypes(){
            mysqli_set_charset($this->connect, "utf8mb4");
            $query = 'SELECT * FROM `contracts_types` WHERE 1';
            $data = mysqli_query($this->connect, $query);
            if (mysqli_num_rows($data) > 0) {
                return $data;
            }
        }

        function insertPracownik ($contract_number, $id_contract_type, $PESEL, $insurance_number, $start_date, $end_date, $salary, $bonus, $id_position, $id_work_location, $id_department, $home_address, $date_of_birth, $photo, $id_car, $first_name, $last_name, $id_country_code, $phone_number, $email_address, $username, $password){
            $end_date = empty($end_date) ? "NULL" : "'".$end_date."'"; 
            $bonus = empty($bonus) ? "NULL" : "'".$bonus."'"; 
            mysqli_set_charset($this->connect, "utf8mb4");
            $query = "INSERT INTO `contracts`(`contract_number`, `id_contract_type`, `PESEL`, `insurance_number`, `employment_period`, `start_date`, `end_date`, `salary`, `bonus`, `id_position`, `id_work_location`, `id_department`) VALUES ('".$contract_number."', '".$id_contract_type."', '".$PESEL."', '".$insurance_number."', '".$start_date."', ".$end_date.", '".$salary."', ".$bonus.", '".$id_position."', '".$id_work_location."', '".$id_department."')";
            $data = mysqli_query($this->connect, $query);
            if($data){
                $id_car = empty($id_car) ? "NULL" : $id_car; 
                $id_contract = $this->connect->insert_id;
                mysqli_set_charset($this->connect, "utf8mb4");
                $query = "INSERT INTO `employees`(`home_address`, `id_contract`, `date_of_birth`, `photo`, `is_admin`, `id_car`) VALUES ('".$home_address."','".$id_contract."', '".$date_of_birth."', '".$photo."', '1', ".$id_car.")";
                $data = mysqli_query($this->connect, $query);
                if($data){
                    $id_employee = $this->connect->insert_id;
                    mysqli_set_charset($this->connect, "utf8mb4");
                    $query = "INSERT INTO `users`(`id_employee`, `id_company`, `first_name`, `last_name`, `id_country_code`, `phone_number`, `email_address`, `username`, `password`, `is_company_admin`, `id_discount`) VALUES ('".$id_employee."', '1', '".$first_name."', '".$last_name."', '".$id_country_code."', '".$phone_number."', '".$email_address."', '".$username."','".$password."', '0', '50')";
                    $data = mysqli_query($this->connect, $query);
                    if (!($data)) {
                        echo "Błąd dodawania do tabeli użytkownicy";
                    }
                } else {
                    echo "Błąd dodawania do tabeli pracownicy";
                }
            } else {
                echo "Błąd dodawania do tabeli umowy";
            }
            header('location: ../BO/admin_employee.php'); 
            $this->close();
        }

        function deleteEmployee($id_employee){
            $query = "Delete from employees where id_employee =".$id_employee.";";
            $data = mysqli_query($this->connect, $query);
            unset($_GET['id']);
            header('location: ../BO/pracownicy.php'); 
            $this->close();
        }

        // function updatePracownik($id_pracownik, $imie, $nazwisko, $adres_zamieszkania, $id_numer_kierunkowy, $numer_telefonu, $adres_e_mail, $PESEL, $numer_umowy, $numer_ubezpieczenia, $data_urodzenia, $data_zatrudnienia, $wynagrodzenie, $zdjecie, $id_stanowisko, $id_lokalizacja_pracy, $id_dzial, $id_samochod){
        //     $query = "UPDATE `pracownicy` SET `imie`='".$imie."',`nazwisko`='".$nazwisko."',`adres_zamieszkania`='".$adres_zamieszkania."',`id_numer_kierunkowy`='".$id_numer_kierunkowy."',`numer_telefonu`='".$numer_telefonu."',`adres_e_mail`='".$adres_e_mail."',`PESEL`='".$PESEL."',`numer_umowy`='".$numer_umowy."',`numer_ubezpieczenia`='".$numer_ubezpieczenia."',`data_urodzenia`='".$data_urodzenia."',`data_zatrudnienia`='".$data_zatrudnienia."',`wynagrodzenie`='".$wynagrodzenie."',`zdjecie`='".$zdjecie."',`id_stanowisko`='".$id_stanowisko."',`id_lokalizacja_pracy`='".$id_lokalizacja_pracy."',`id_dzial`='".$id_dzial."',`id_samochod`='".$id_samochod.";";
        //     $data = mysqli_query($this->connect, $query);
        //     unset($_GET['id']);
        //     header('location: ../BO/pracownicy.php');  
        //     $this->close();
        // }
    }
?>
