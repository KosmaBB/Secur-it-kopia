<?php
    include_once ('../include/functions.php');
    include_once('../DB/db_contact.php');

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

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
    $row = $baza->selectContactByID($id_contact_form);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $description = $_POST['description'];
        $id_employee = $row['id_employee'] ?? null; // Ensure id_employee is retrieved safely
        if ($id_employee !== null) {
            try {
                $baza->insertTaskHistory($id_contact_form, $id_employee, $description, 'Zwrócone');
                $baza->updateContactSetStatus($id_contact_form, 'Zwrócone', $id_employee);
                header('Location: my_forms.php');
                exit();
            } catch (Exception $e) {
                echo "<p class='error'>Wystąpił błąd: " . $e->getMessage() . "</p>";
            }
        } else {
            echo "<p class='error'>Nie można zwrócić zadania, ponieważ brak przypisanego pracownika.</p>";
        }
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
        <title>Secur IT | Zwróć Zadanie</title>
    </head>
    <body>
        <?php
            include("./header.php");
            include("./nav.php");
            include("./footer.php");
        ?>
        <main class="main">
            <div class="task-container">
                <h1>Zwróć Zadanie</h1>
                <?php if ($row): ?>
                    <div class="form-item">
                        <p>Imię: <?php echo $row['first_name']; ?></p>
                        <p>Nazwisko: <?php echo $row['last_name']; ?></p>
                        <p>E-mail: <?php echo $row['email']; ?></p>
                        <p>Numer telefonu: <?php echo $row['country_code'] . " " . $row['phone_number']; ?></p>
                        <p>Tytuł: <?php echo $row['title']; ?></p>
                        <p>Wiadomość: <?php echo $row['message']; ?></p>
                        <p>Status: <?php echo $row['status']; ?></p>
                        <?php if (isset($row['th_status']) && ($row['th_status'] == 'Oczekuje potwierdzenia' || $row['th_status'] == 'Wolne')): ?>
                            <p>Opis: <?php echo $row['description']; ?></p>
                        <?php endif; ?>
                    </div>
                    <form action="return_assignment.php?id_contact_form=<?php echo $id_contact_form; ?>" method="POST">
                        <label for="description">Opis:</label>
                        <textarea id="description" name="description" required></textarea>
                        <button type="submit">Wyślij</button>
                    </form>
                <?php else: ?>
                    <p class="no-data">Brak danych do wyświetlenia.</p>
                <?php endif; ?>
            </div>
        </main>
    </body>
</html>
