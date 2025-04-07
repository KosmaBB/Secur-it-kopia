<?php
    include_once ('../include/functions.php');
    include_once('../DB/db_contact.php');
?>
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="./script.js" defer></script>
        <script src="https://kit.fontawesome.com/1deffa5961.js" crossorigin="anonymous"></script>
        <link rel="shortcut icon" href="../images/ikona.png">
        <title>Secur IT | Wysłane Formularze</title>
    </head>
    <body>
        <div class="tlo"></div>
        <main class="main">
        <?php
                include("header.php");
                include("nav.php");
                include("footer.php");

                $baza = new db_contact;
                $baza->databaseConnect();
                if(!empty($_GET)){
                    $baza->databaseConnect();
                    if(isset($_GET['opcja'])){
                        if($_GET['opcja'] == 'edit_form'){
                            $id_contact_form = $_GET['id_contact_form'];
                            $title = $_GET['title'];
                            $message = $_GET['message'];
                            $status = $_GET['status'];
                            $baza->updateContactMessage($id_contact_form, $title, $message, $status);
                        }
                    }
                    else{
                        echo "<p>Błąd w zmianie wpisu.</p>";
                    }
                }

                $data = $baza->selectContactByIdUser($id_user);
                if ($data) {
                    while ($row = mysqli_fetch_assoc($data)) {
                        echo "<form class='form-item modern-form' method='GET'>
                                <div class='form-group'>
                                    <label>Imię:</label>
                                    <p>".$row['first_name']."</p>
                                </div>
                                <div class='form-group'>
                                    <label>Nazwisko:</label>
                                    <p>".$row['last_name']."</p>
                                </div>
                                <div class='form-group'>
                                    <label>E-mail:</label>
                                    <p>".$row['email']."</p>
                                </div>
                                <div class='form-group'>
                                    <label>Numer telefonu:</label>
                                    <p>".$row['country_code']." ".($row['phone_number'])."</p>
                                </div>
                                <div class='form-group'>
                                    <label>Tytuł:</label>
                                    <p>".$row['title']."</p>
                                </div>
                                <div class='form-group'>
                                    <label>Wiadomość:</label>
                                    <p>".$row['message']."</p>
                                </div>
                                <div class='form-group'>
                                    <label>Status:</label>
                                    <p>".$row['status']."</p>
                                </div>
                                <div class='form-group'>
                                    <label>Opis:</label>
                                    <p>".$row['description']."</p>
                                  </div>";
                        if ($row['status'] == 'Oczekuje potwierdzenia' || $row['status'] == 'Wolne') {
                            echo "<div class='button-group'>
                                    <button class='button'><a href='edit_form.php?id_contact_form=".$row['id_contact_form']."'>Edytuj formularz</a></button>
                                </div>";
                        }
                        if ($row['status'] == 'Oczekuje potwierdzenia') {
                            echo "<div class='button-group'>
                                    <button class='button delete'><a href='end_task.php?opcja=end_task&id_contact_form=".$row['id_contact_form']."'>Zakończ</a></button>
                                    <button class='button delete'><a href='return_assignment.php?opcja=return_assignment&id_contact_form=".$row['id_contact_form']."'>Zwróć zadanie</a></button>
                                    <button class='button delete'><a href='delete_task.php?opcja=delete_task&id_contact_form=".$row['id_contact_form']."'>Usuń zadanie</a></button>
                                  </div>";
                        }
                        echo "</form>";
                    }
                }
                else {
                    echo "<p>Brak wysłanych formularzy</p>";
                }
        ?>
        </main>
    </body>
</html>
