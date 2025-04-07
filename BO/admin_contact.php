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
        <title>Secur IT | Admin - Kontakt</title>
    </head>
    <body>
        <?php
            include("./admin_header.php");
            include("./admin_nav.php");
            include("../DB/db_contact.php");

            $baza = new db_contact();
            $baza->databaseConnect();
            $kontakty = $baza->selectContact();

            if(isset($_GET['opcja'])){
                if($_GET['opcja'] == 'assign_task'){
                    $id_contact_form = $_GET['id_contact_form'];
                    $baza->databaseConnect();
                    $baza->updateContactSetEmployee($id_contact_form, $id_employee);
                }
                if($_GET['opcja'] == 'clear_task_assingment'){
                    $baza->databaseConnect();
                    $id_contact_form = $_GET['id_contact_form'];
                }
            }
        ?>
        <main class="main modern-container">
            <h1 class="center-text">Lista Zadań</h1>
            <div class="button-container center-content">
                <a class="button modern-button normal-size" href='admin_my_tasks.php'>Moje Zadania</a>
            </div>
            <?php if ($kontakty && mysqli_num_rows($kontakty) > 0): ?>
            <form class="modern-form" action="admin_contact.php" method='get'>
                <table class="kontakt_table modern-table">
                    <thead>
                        <tr>
                            <th>Imię</th>
                            <th>Nazwisko</th>
                            <th>E-mail</th>
                            <th>Numer Telefonu</th>
                            <th>Tytuł</th>
                            <th>Wiadomość</th>
                            <th>Zgoda na przetwarzanie danych</th>
                            <th>Status</th>
                            <th>Przypisano do</th>
                            <th>Akcje</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($kontakty)): ?>
                            <tr>
                                <td><?php echo $row['first_name']; ?></td>
                                <td><?php echo $row['last_name']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo $row['country_code'] . " " . $row['phone_number']; ?></td>
                                <td><?php echo $row['title']; ?></td>
                                <td><?php echo substr($row['message'], 0, 150) . " ..."; ?></td>
                                <td><?php echo $row['consent'] ? 'Tak' : 'Nie'; ?></td>
                                <td><?php echo $row['status']; ?></td>
                                <td><?php echo $row['ufn'] ? $row['ufn'] . " " . $row['uln'] : 'Nieprzypisano'; ?></td>
                                <td>
                                    <?php if ($row['ufn'] == null): ?>
                                        <a class="button modern-button" href='admin_contact.php?opcja=assign_task&id_contact_form=<?php echo $row['id_contact_form']; ?>'>Przypisz</a>
                                    <?php endif; ?>
                                    <?php if($row['id_employee'] == $id_employee && $row['status'] != 'Oczekuje potwierdzenia'): ?>
                                        <a class="button delete modern-button" href='release_task.php?opcja=clear_task_assingment&id_contact_form=<?php echo $row['id_contact_form']; ?>'>Zwolnij</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </form> 
            <?php else: ?>
                <p class="empty-message">Brak danych do wyświetlenia.</p>
            <?php endif; ?>
            <?php $baza->close(); ?>
        </main>
    </body>
</html>