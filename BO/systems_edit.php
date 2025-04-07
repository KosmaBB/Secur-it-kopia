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
        <title>Secur IT | Admin - Edytuj Systemy Operacyjne</title>
    </head>
    <body>
        <?php
            include("./admin_header.php");
            include("./admin_nav.php");
        ?>
        <div class="tlo"></div>
        <main class="main">
            <div class="formularz modern-form">
                <h1 class="center-text">Edytuj System Operacyjny</h1>
                <?php
                    include('../DB/db_services.php');
                    $baza = new db_services();
                
                    if(!empty($_GET)){                
                        $baza->databaseConnect();
                        $id_service=$_GET['id_service'];
                        $data = $baza->selectServiceById($id_service);
                        if (!empty($data)){
                            while($row = mysqli_fetch_assoc($data))
                            {
                                echo "<form class='form-add-service' action='./admin_systems.php' method='get'>
                                    <label for='name'>Nazwa</label>
                                    <input type='text' name='name' id='name' value='".$row['name']."' required>
                                    <label for='description'>Opis</label>
                                    <textarea name='description' id='description' rows='5' required>".$row['description']."</textarea>
                                    <label for='price'>Cena</label>
                                    <input type='number' name='price' id='price' class='price' value=".$row['price']." required>
                                    <input type='hidden' name='id_service' id='id_service' value=".$row['id_service'].">
                                    <input type='hidden' name='opcja' id='opcja' value='edytuj'>
                                    <button type='submit' class='modern-button'>Zapisz zmiany</button>
                                </form>";
                            }
                        }
                    }
                ?>
            </div>
        </main>        
    </body>
</html>