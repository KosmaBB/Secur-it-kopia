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
    <title>Secur IT | Admin - O Firmie</title>
</head>
<body>
    <div class="tlo"></div>
    <main class="main">
        <?php
            include("./admin_header.php");
            include("./admin_nav.php");

            include('../DB/db_about_company.php');
            $baza = new db_about_company();
        
            if(!empty($_GET)){
                $baza->databaseConnect();
                if(isset($_GET['del']))
                {
                    $id_about_company=$_GET['id_about_company'];
                    $baza->deleteAbout_company($id_about_company);
                }
                if(isset($_GET['opcja'])){
                    if($_GET['opcja'] == 'edytuj'){
                        $id_about_company = $_GET['id_about_company'];
                        $title = $_GET['title'];
                        $description = $_GET['description'];
                        $baza->updateAbout_company ($id_about_company, $title, $description);
                    }
                }
                else{
                    echo "<p>Wpisu nie ma w naszej bazie</p>";
                }
            }
            
            $baza->databaseConnect();
            $data = $baza->selectAbout_company();
            if (!empty($data)){
            ?>
            <div class="tresc">
                <div class="button-container">
                    <button class="button add-entry"><a href="./add_about_company.php">Dodaj wpis</a></button>
                </div>
                <?php
                    while($row = mysqli_fetch_assoc($data))
                    {
                        echo "<div class='artykul no-hover'>
                        <h3>".$row['title']."</h3>
                        <p>".$row['description']."</p>
                        <div class='buttons'>
                            <button class='button delete'><a href='admin_about_company.php?del=True&id_about_company=".$row['id_about_company']."'>Usuń</a></button>
                            <button class='button edit'><a href='admin_edit_about_company.php?id_about_company=".$row['id_about_company']."'>Edytuj</a></button>
                        </div>
                        </div>";
                    }
                } else {
                    echo "<p>Brak wpisów</p>";
                }
                $baza->close();
                ?>
            </div>
        </main>
    </body>
</html>