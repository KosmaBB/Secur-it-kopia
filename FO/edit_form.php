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
        <title>Secur IT | Edytuj Formularz</title>
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

                if($_GET){
                    $id_contact_form = $_GET['id_contact_form'];
                }

                $data = $baza->selectContactByID($id_contact_form);
                if ($data) {
                    while ($row = mysqli_fetch_assoc($data)) {
                        echo "<form class='form-item modern-form' action='./my_forms.php' method='GET'>
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
                                    <input type='hidden' name='title' value='".$row['title']."'>
                                </div>
                                <div class='form-group'>
                                    <label for='message'>Wiadomość:</label>
                                    <textarea name='message' id='message' class='styled-textarea'>".$row['message']."</textarea>
                                </div>
                                <div class='form-group'>
                                    <label>Status:</label>
                                    <p>".$row['status']."</p>
                                    <input type='hidden' name='status' value='".$row['status']."'>
                                </div>
                                <input type='hidden' name='opcja' value='edit_form'>
                                <input type='hidden' name='id_contact_form' value=".$row['id_contact_form'].">
                                <div class='button-group'>
                                    <input class='button' type='submit' value='Edytuj'>
                                </div>
                            </form>";
                    }
                }
                else {
                    echo "<p>Brak wysłanych formularzy</p>";
                }
        ?>
        </main>
    </body>
</html>
