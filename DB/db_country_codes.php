<?php
    class db_country_codes extends db_connection {
        function selectCountryCodes() {
            mysqli_set_charset($this->connect, "utf8mb4");
            $query = 'SELECT * FROM country_codes WHERE 1';
            $data = mysqli_query($this->connect, $query);
            if (mysqli_num_rows($data) > 0) {
                return $data;
            }
        }
        
        function selectCountryCodesPolska() {
            mysqli_set_charset($this->connect, "utf8mb4");
            $query = 'SELECT * FROM country_codes WHERE country = "Polska"';
            $data = mysqli_query($this->connect, $query);
            if (mysqli_num_rows($data) > 0) {
                return $data;
            }
        }
    }
?>
