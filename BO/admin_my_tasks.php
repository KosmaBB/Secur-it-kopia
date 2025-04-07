<?php
    include_once ('../include/functions.php');
    include_once('../DB/db_contact.php');

    session_start();
    if (!isset($_SESSION['id_employee']) || $_SESSION['id_employee'] == 0) {
        header('Location: ../FO/account.php');
        exit();
    }

    $id_employee = $_SESSION['id_employee'];
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
        <title>Secur IT | Admin - Moje Zadania</title>
    </head>
    <body>
        <?php
            include("./admin_header.php");
            include("./admin_nav.php");

            $baza = new db_contact();
            $baza->databaseConnect();
            $tasks = $baza->selectTasksByEmployee($id_employee);

            if(isset($_GET['opcja'])){
                $baza->databaseConnect();
                $id_contact_form = $_GET['id_contact_form'];
                if($_GET['opcja'] == 'clear_task_assignment'){
                    $baza->updateContactSetEmployeeToNull($id_contact_form);
                }
                if($_GET['opcja'] == 'send_to_verify'){
                    $baza->updateContactSetStatus($id_contact_form, 'Oczekuje potwierdzenia', $id_employee);
                }
                if($_GET['opcja'] == 'confirm_send'){
                    $baza->updateContactSetStatus($id_contact_form, 'Zakończono', $id_employee);
                }
                if($_GET['opcja'] == 'cancel_send'){
                    $baza->updateContactSetStatus($id_contact_form, 'W trakcie realizacji', $id_employee);
                }
                if($_GET['opcja'] == 'send_to_approval'){
                    $baza->updateContactSetStatus($id_contact_form, 'Oczekuje potwierdzenia', $id_employee);
                }
            }
        ?>
        <main class="main modern-container">
            <section class="tasks-section">
                <h1 class="center-text">Moje Zadania</h1>
                <!-- Remove inline styles for "Powrót" button -->
                <div class="button-container center-content">
                    <a class="button modern-button back-button" href="admin_contact.php">Powrót</a>
                </div>
                <?php if ($tasks && mysqli_num_rows($tasks) > 0): ?>
                <form class="modern-form" action="admin_my_tasks.php" method='get'>
                    <table class="kontakt_table modern-table" style="table-layout: fixed; border-collapse: collapse;">
                        <thead style="position: sticky; top: 0; background-color: #333; z-index: 1;">
                            <tr>
                                <th>Imię</th>
                                <th>Nazwisko</th>
                                <th>E-mail</th>
                                <th>Numer Telefonu</th>
                                <th>Tytuł</th>
                                <th>Wiadomość</th>
                                <th>Status</th>
                                <th>Opis</th>
                                <th>Akcja</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($tasks)): ?>
                            <tr>
                                <td><?php echo $row['first_name']; ?></td>
                                <td><?php echo $row['last_name']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo $row['country_code'] . " " . $row['phone_number']; ?></td>
                                <td><?php echo $row['title']; ?></td>
                                <td><?php echo substr($row['message'], 0, 150) . " ..."; ?></td>
                                <td><?php echo $row['status']; ?></td>
                                <td><?php echo $row['description']; ?></td>
                                <td>
                                    <div class="action-buttons" style="display: flex; flex-direction: column; gap: 5px;">
                                        <?php
                                        if ($row['id_employee'] == $id_employee && $row['status'] != 'Oczekuje potwierdzenia') {
                                            echo "<a class='button modern-button' style='padding: 5px 10px; font-size: 14px;' href='admin_my_tasks.php?opcja=clear_task_assignment&id_contact_form=".$row['id_contact_form']."'>Zwolnij zadanie</a>";
                                            if ($row['id_user'] == null) {
                                                echo "<a class='button modern-button' style='padding: 5px 10px; font-size: 14px;' href='admin_my_tasks.php?opcja=send_to_verify&id_contact_form=".$row['id_contact_form']."'>Odeślij do potwierdzenia</a>";
                                            }
                                            // Add "Wyślij do zatwierdzenia" button
                                            echo "<a class='button modern-button' style='padding: 5px 10px; font-size: 14px;' href='admin_my_tasks.php?opcja=send_to_approval&id_contact_form=".$row['id_contact_form']."'>Wyślij do zatwierdzenia</a>";
                                        } elseif ($row['status'] == 'Oczekuje potwierdzenia' && $row['id_user'] == null) {
                                            echo "<a class='button modern-button' style='padding: 5px 10px; font-size: 14px;' href='admin_my_tasks.php?opcja=confirm_send&id_contact_form=".$row['id_contact_form']."'>Potwierdź wysłanie</a>";
                                            echo "<a class='button delete modern-button' style='padding: 5px 10px; font-size: 14px;' href='admin_my_tasks.php?opcja=cancel_send&id_contact_form=".$row['id_contact_form']."'>Odwołaj wysłanie</a>";
                                        }
                                        ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </form>
                <?php else: ?>
                    <p class="empty-message">Brak przypisanych zadań.</p>
                <?php endif; ?>
                <?php $baza->close(); ?>
            </section>
        </main>
    </body>
</html>
