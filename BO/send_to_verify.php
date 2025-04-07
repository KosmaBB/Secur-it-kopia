<?php
    include_once ('../include/functions.php');
    include_once('../DB/db_contact.php');

    session_start();
    if (!isset($_SESSION['id_employee']) || $_SESSION['id_employee'] == 0) {
        header('Location: ../FO/account.php');
        exit();
    }

    $id_contact_form = $_GET['id_contact_form'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $status = 'Oczekuje potwierdzenia';
        $description = $_POST['description'];
        $baza = new db_contact();
        $baza->databaseConnect();
        $baza->insertTaskHistory($id_contact_form, $id_employee, $description, $status);
        $baza->databaseConnect();
        $baza->updateContactSetStatus($id_contact_form, $status, $id_employee);
        header('Location: admin_my_tasks.php');
        exit();
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
        <title>Secur IT | Admin - Odeślij Zadanie</title>
    </head>
    <body>
        <?php
            include("./admin_header.php");
            include("./admin_nav.php");
        ?>
        <main class="main">
            <h1>Odeślij Zadanie</h1>
            <form action="send_to_verify.php?id_contact_form=<?php echo $id_contact_form; ?>" method="POST">
                <label for="description">Opis:</label>
                <textarea id="description" name="description" required></textarea>
                <button type="submit">Wyślij</button>
            </form>
        </main>
    </body>
</html>
