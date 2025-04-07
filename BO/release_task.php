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
        <title>Secur IT | Admin - Zwolnij Zadanie</title>
    </head>
    <body>
        <?php
            include("./admin_header.php");
            include("./admin_nav.php");
            include("../DB/db_contact.php");

            $baza = new db_contact();
            $baza->databaseConnect();

            if (!empty($_GET['id_contact_form']) && is_numeric($_GET['id_contact_form'])) {
                $id_contact_form = $_GET['id_contact_form'];
                $data = $baza->selectContactByID($id_contact_form);
            
                if (isset($_GET['opcja']) && $_GET['opcja'] == 'release_task') {
                    $description = $_GET['description'] ?? ''; 
                    $status = 'Wolne';
            
                    if (!empty($description)) {
                        $id_employee = null;
                        $baza->updateContactSetStatus($id_contact_form, $status, $id_employee);
                        $baza->databaseConnect();
                        $baza->insertTaskHistory($id_contact_form, $id_employee,  $description, $status);
                        echo "<p class='success-message'>Zadanie zostało zwolnione pomyślnie.</p>";
                    } else {
                        echo "<p class='error-message'>Opis nie może być pusty.</p>";
                    }
                }
            } else {
                die("<p class='error-message'>Błąd: Brak lub nieprawidłowy id_contact_form.</p>");
            }
        ?>
        <main class="main modern-container">
            <section class="modern-form">
                <h1 class="center-text">Zwolnij Zadanie</h1>
                <?php if (!empty($data)): ?>
                    <?php $row = mysqli_fetch_assoc($data); ?>
                    <form action="release_task.php" method="GET">
                        <div class="form-group">
                            <label>Imię:</label>
                            <p><?php echo $row['first_name']; ?></p>
                        </div>
                        <div class="form-group">
                            <label>Nazwisko:</label>
                            <p><?php echo $row['last_name']; ?></p>
                        </div>
                        <div class="form-group">
                            <label>E-mail:</label>
                            <p><?php echo $row['email']; ?></p>
                        </div>
                        <div class="form-group">
                            <label>Numer telefonu:</label>
                            <p><?php echo $row['country_code'] . " " . $row['phone_number']; ?></p>
                        </div>
                        <div class="form-group">
                            <label>Wiadomość:</label>
                            <p><?php echo $row['message']; ?></p>
                        </div>
                        <div class="form-group">
                            <label>Status zadania:</label>
                            <p><?php echo $row['status']; ?></p>
                        </div>
                        <div class="form-group">
                            <label for="description">Opis:</label>
                            <textarea id="description" name="description" class="styled-textarea" required></textarea>
                        </div>
                        <input type="hidden" name="opcja" value="release_task">
                        <input type="hidden" name="id_contact_form" value="<?php echo $row['id_contact_form']; ?>">
                        <div class="button-group">
                            <button class="modern-button delete" type="submit">Zwolnij zadanie</button>
                        </div>
                    </form>
                <?php else: ?>
                    <p class="empty-message">Brak danych do wyświetlenia.</p>
                <?php endif; ?>
            </section>
        </main>
    </body>
</html>