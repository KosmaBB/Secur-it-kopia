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
        <main class="main" id="main">
            <?php
                include("nav.php");
            ?>
            
            <h1>Wysłane Formularze</h1>
            
            <div class="forms-container">
                <?php
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
                    if ($data && mysqli_num_rows($data) > 0) {
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
            </div>
            
            <?php
                include("footer.php");
            ?>
        </main>
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const sidebar = document.getElementById('holo-sidebar');
                const main = document.getElementById('main');

                const savedState = localStorage.getItem('holoSidebarState');
                if (savedState === 'collapsed') {
                    main.classList.add('sidebar-collapsed');
                }
                
                if (sidebar) {
                    const observer = new MutationObserver(function(mutations) {
                        mutations.forEach(function(mutation) {
                            if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                                if (sidebar.classList.contains('collapsed')) {
                                    main.classList.add('sidebar-collapsed');
                                } else {
                                    main.classList.remove('sidebar-collapsed');
                                }
                            }
                        });
                    });
                    
                    observer.observe(sidebar, { attributes: true });
                }

                const statusElements = document.querySelectorAll('.form-group:nth-child(7) p');
                statusElements.forEach(status => {
                    if (status.textContent.includes('Oczekuje potwierdzenia')) {
                        status.style.backgroundColor = 'rgba(255, 193, 7, 0.2)';
                        status.style.borderColor = 'rgba(255, 193, 7, 0.4)';
                        status.style.color = '#ffc107';
                    } else if (status.textContent.includes('Wolne')) {
                        status.style.backgroundColor = 'rgba(0, 204, 255, 0.2)';
                        status.style.borderColor = 'rgba(0, 204, 255, 0.4)';
                        status.style.color = '#00ccff';
                    } else if (status.textContent.includes('Zakończone')) {
                        status.style.backgroundColor = 'rgba(40, 167, 69, 0.2)';
                        status.style.borderColor = 'rgba(40, 167, 69, 0.4)';
                        status.style.color = '#28a745';
                    }
                });
            });
        </script>
    </body>
</html>