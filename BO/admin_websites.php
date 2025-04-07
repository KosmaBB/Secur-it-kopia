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
    <title>Secur IT | Admin - Strony Internetowe</title>
</head>
<body>
    <div class="tlo"></div>
    <main class="main">
        <?php
            include("./admin_header.php");
            include("./admin_nav.php");
            // include("footer_admin.php");

            include('../DB/db_services.php');
            $baza = new db_services();
        
            if(!empty($_GET)){
                $baza->databaseConnect();
                if(isset($_GET['del']))
                {
                    $id_service=$_GET['id_service'];
                    $baza->deleteServices($id_service);
                }
                if(isset($_GET['opcja'])){
                    if($_GET['opcja'] == 'edytuj'){
                        $id_service = $_GET['id_service'];
                        $name = $_GET['name'];
                        $description = $_GET['description'];
                        $price = $_GET['price'];
                        $baza->updateServices ($id_service, $name, $description, $price);
                    }
                }
                else{
                    echo "<p>Usługi nie ma w naszej bazie</p>";
                }
            }
            
            $baza->databaseConnect();
            $data = $baza->selectServices_websites();
            if (!empty($data)){ 
        ?>
            <div class="services">
                <button class="modern-button"><a href="./add_services.php" class="button-link">Dodaj usługę</a></button>
                <div class="services-container">
                    <?php
                        while($row = mysqli_fetch_assoc($data)) {
                            echo "<div class='service-card'>
                                    <h3>".$row['name']."</h3>
                                    <p>".$row['description']."</p>
                                    <p><strong>Cena:</strong> ".$row['price']." zł</p>
                                    <div class='buttons'>
                                        <button class='modern-button delete'><a href='admin_websites.php?del=True&id_service=".$row['id_service']."' class='button-link'>Usuń usługę</a></button>
                                        <button class='modern-button'><a href='websites_edit.php?id_service=".$row['id_service']."' class='button-link'>Edytuj usługę</a></button>
                                    </div>
                                  </div>";
                        }
                    ?>
                </div>
            </div>
            <?php
                } else {
                    echo "Brak Usług";
                }
                $baza->close();
            ?>
        </main>
    </body>
</html>