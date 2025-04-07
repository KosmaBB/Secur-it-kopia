<?php
    include_once ('../include/functions.php');
    include_once('../DB/db_contact.php');

    session_start();
    if (!isset($_SESSION['id_user'])) {
        header('Location: ../FO/account.php');
        exit();
    }

    $id_contact_form = $_GET['id_contact_form'];
    $baza = new db_contact();
    $baza->databaseConnect();
    $row = $baza->selectContactByID($id_contact_form);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $description = $_POST['description'] ?? '';
        $id_employee = $row['cf.id_employee'];
        $baza->insertTaskHistory($id_contact_form, $id_employee, $description, 'Zrealizowano');
        $baza->updateContactSetStatus($id_contact_form, 'Zrealizowano', $id_employee);
        header('Location: my_forms.php');
        exit();
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
        <title>Secur IT | Zakończ Zadanie</title>
    </head>
    <body>
        <?php
            include("./header.php");
            include("./nav.php");
            include("./footer.php");
        ?>
        <main class="main">
            <div class="task-container">
                <h1>Zakończ Zadanie</h1>
                <?php if ($row): ?>
                    <div class="form-item">
                        <p>Imię: <?php echo $row['first_name'] ?? 'Brak danych'; ?></p>
                        <p>Nazwisko: <?php echo $row['last_name'] ?? 'Brak danych'; ?></p>
                        <p>E-mail: <?php echo $row['email'] ?? 'Brak danych'; ?></p>
                        <p>Numer telefonu: <?php echo ($row['country_code'] ?? '') . " " . ($row['phone_number'] ?? 'Brak danych'); ?></p>
                        <p>Tytuł: <?php echo $row['title'] ?? 'Brak danych'; ?></p>
                        <p>Wiadomość: <?php echo $row['message'] ?? 'Brak danych'; ?></p>
                        <p>Status: <?php echo $row['status'] ?? 'Brak danych'; ?></p>
                        <?php if (isset($row['th_status']) && ($row['th_status'] == 'Oczekuje potwierdzenia' || $row['th_status'] == 'Wolne')): ?>
                            <p>Opis: <?php echo $row['description'] ?? 'Brak danych'; ?></p>
                        <?php endif; ?>
                    </div>
                    <form action="end_task.php?id_contact_form=<?php echo $id_contact_form; ?>" method="POST">
                        <label for="description">Opis (opcjonalnie):</label>
                        <textarea id="description" name="description"></textarea>
                        <button type="submit">Zakończ</button>
                    </form>
                <?php else: ?>
                    <p class="no-data">Brak danych do wyświetlenia.</p>
                <?php endif; ?>
            </div>
        </main>
    </body>
</html>
