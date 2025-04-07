<?php
    include_once ('../include/functions.php');
    include_once('../DB/db_contact.php');

    session_start();
    if (!isset($_SESSION['id_user'])) {
        header('Location: ../FO/account.php');
        exit();
    }

    if (!isset($_GET['id_contact_form']) || !is_numeric($_GET['id_contact_form'])) {
        echo "<p class='error'>Nieprawidłowy identyfikator formularza.</p>";
        exit();
    }

    $id_contact_form = intval($_GET['id_contact_form']); // Sanitize input
    $baza = new db_contact();
    $baza->databaseConnect();

    try {
        $row = $baza->getContactDetails($id_contact_form); // Fetch contact details
        if (!$row) {
            echo "<p class='error'>Nie znaleziono danych dla podanego identyfikatora.</p>";
            exit();
        }

        $baza->insertTaskHistory($id_contact_form, $id_employee, $description, 'Usunięte'); // Insert task history
        $baza->deleteContact($id_contact_form); // Call the deleteContact method
        header('Location: my_forms.php'); // Redirect back to the forms page
        exit();
    } catch (Exception $e) {
        echo "<p class='error'>Wystąpił błąd podczas usuwania zadania: " . $e->getMessage() . "</p>";
    }
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
        <title>Secur IT | Usuń Zadanie</title>
    </head>
    <body>
        <?php
            include("./header.php");
            include("./nav.php");
            include("./footer.php");
        ?>
        <main class="main">
            <div class="task-container">
                <h1>Usuń Zadanie</h1>
                <?php if (isset($row)): ?> <!-- Ensure $row is defined -->
                    <div class="form-item">
                        <p>Imię: <?php echo $row['first_name']; ?></p>
                        <p>Nazwisko: <?php echo $row['last_name']; ?></p>
                        <p>E-mail: <?php echo $row['email']; ?></p>
                        <p>Numer telefonu: <?php echo $row['country_code'] . " " . $row['phone_number']; ?></p>
                        <p>Tytuł: <?php echo $row['title']; ?></p>
                        <p>Wiadomość: <?php echo $row['message']; ?></p>
                        <p>Status: <?php echo $row['status']; ?></p>
                        <?php if ($row['th_status'] == 'Oczekuje potwierdzenia' || $row['th_status'] == 'Wolne'): ?>
                            <p>Opis: <?php echo $row['description']; ?></p>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <p class="no-data">Brak danych do wyświetlenia.</p>
                <?php endif; ?>
            </div>
        </main>
    </body>
</html>
