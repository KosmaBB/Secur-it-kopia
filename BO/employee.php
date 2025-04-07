<?php
    include_once ('../include/functions.php');

    if ($id_employee == 0){
        header('Location: ../FO/account.php');
    }
?>
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./admin.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="./admin.js" defer></script>
        <script src="https://kit.fontawesome.com/1deffa5961.js" crossorigin="anonymous"></script>
        <link rel="shortcut icon" href="../images/ikona.png">
        <title>Secur IT | Admin Panel</title>
    </head>
    <body>
        <div class="tlo"></div>
        <main class="main">
            <?php
                include("./admin_header.php");
                include("./admin_nav.php");
                // include("footer_admin.php");
            ?>
            <div id="contactInfo" class="contact-container">
            <a href="./admin_employee.php" class="button back-button">Powrót</a>
            <?php
                include('../DB/db_employees.php');
                $baza = new db_employees();
                
                $baza->databaseConnect();
                $id_employee = $_GET['id_employee'];
                $data = $baza->selectEmployeeById($id_employee);
                
                while($row = mysqli_fetch_assoc($data))
                {
                    echo "<div class='pracownik-card'>";
                    echo "<img class='photo' src='".$row['photo']."' alt='Employee Photo'><br>";
                    echo "<h2>".$row['first_name']." ".$row['last_name']."</h2>";
                    echo "<p><strong>Numer telefonu:</strong> " .($row['country_code']) . " " .($row['phone_number']) . "</p>";
                    echo "<p><strong>Adres e-mail:</strong> ".$row['email_address']."</p>";
                    echo "<p><strong>Adres zamieszkania:</strong> ".$row['home_address']."</p>";
                    echo "<p><strong>Data urodzenia:</strong> ".$row['date_of_birth']."</p>";
                    echo "<p><strong>Numer umowy:</strong> ".$row['contract_number']."</p>";
                    echo "<p><strong>Typ umowy:</strong> ".$row['contract_type']."</p>";
                    echo "<p><strong>PESEL:</strong> ".$row['PESEL']."</p>";
                    echo "<p><strong>Numer ubezpieczenia:</strong> ".$row['insurance_number']."</p>";
                    echo "<p><strong>Data rozpoczęcia pracy:</strong> ".$row['start_date']."</p>";
                    echo "<p><strong>Data zakończenia pracy:</strong> ".$row['end_date']."</p>";
                    echo "<p><strong>Wynagrodzenie:</strong> ".$row['salary']."</p>";
                    echo "<p><strong>Wysokość premii:</strong> ".$row['bonus']."</p>";
                    echo "<p><strong>Lokalizacja pracy:</strong> ".$row['id_work_location']."</p>";
                    echo "<p><strong>Stanowisko:</strong> ".$row['name']."</p>";
                    echo "<p><strong>Dział:</strong> ".$row['department_name']."</p>";
                    echo "</div>";
                }

                $baza->close();
            ?>
            </div>
        </main>
    </body>
</html>