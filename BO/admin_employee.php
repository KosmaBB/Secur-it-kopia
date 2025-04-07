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
        <title>Secur IT | Admin - Pracownicy</title>
    </head>
    <body>
        <?php
            include("./admin_header.php");
            include("./admin_nav.php");
        ?>
        <main class="main">
            <div class="tresc">
                <div class="button-container">
                    <a class="button add-entry" href="./add_employee.php">
                        <i class="fa-solid fa-user-plus"></i> Dodaj pracownika
                    </a>
                </div>
                <?php
                    include('../DB/db_employees.php');
                    $baza = new db_employees();
                    $baza->databaseConnect();
                    $data = $baza->selectEmployee();
                    if (!empty($data)){
                ?>
                <div class="pracownicy-container">
                    <?php
                        while($row = mysqli_fetch_assoc($data))
                        {
                            echo "<a href='./employee.php?id_employee=".$row['id_employee']."' class='pracownik'>";
                            echo "<img class='photo' src='".$row['photo']."'><br>";
                            echo "<p>Imię: ".$row['first_name']."</p>";
                            echo "<p>Nazwisko: ".$row['last_name']."</p>";
                            echo "<p>Stanowisko: ".$row['name']."</p>";
                            if(!empty($row['department_name'])){
                                echo "<p>Dział: ".$row['department_name']."</p>";
                            }
                            echo "</a>";
                        }
                    ?>
                </div>
                <?php
                    } else {
                        echo "<p class='empty-message'>Brak pracowników</p>";
                    }
                    $baza->close();
                ?>
            </div>
        </main>
    </body>
</html>