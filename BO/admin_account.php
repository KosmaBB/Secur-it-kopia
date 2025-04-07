<?php
    include('../DB/db_accounts.php');
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
    <title>Secur IT | Admin Konto</title>
</head>
<body>
    <div class="tlo"></div>
    <main class="main">
    <?php
            include("admin_header.php");
            include("admin_nav.php");

            if (/*isset($_SESSION['loggedin']) && */ $_SESSION['loggedin'] === true) {
                $id_user = $_SESSION['id_user'];

                $baza = new db_accounts();
                $baza->databaseConnect();
                $data = $baza->selectCustomerById($id_user, null);

                if ($data && mysqli_num_rows($data) > 0) {
                    $user = mysqli_fetch_assoc($data);
                    echo "<div class='user_page'>";
                    echo "<h2>Witaj, " . ($user['username']) . "!</h2>";
                    echo "<p>Imię: " . ($user['first_name']) . "</p>";
                    echo "<p>Nazwisko: " . ($user['last_name']) . "</p>";
                    echo "<p>Numer telefonu: " . ($user['ucc']) . " " . ($user['upn']) . "</p>";
                    echo "<p>Email: " . ($user['uea']) . "</p>";

            // Sprawdzamy, czy użytkownik należy do firmy
            if (!empty($user['company_name'])) {
                echo "</div><div class='firma_page'>";
                echo "<h2>Twoja Firma:</h2>";
                echo "<p>Nazwa firmy:  " . ($user['company_name']) . " " . ($user['additional_name']) . "</p>";
                echo "<p>NIP: " . ($user['tax']) . "</p>";
                echo "<p>Numer telefonu firmy: " . ($user['ccc']) . " " . ($user['cpn']) . "</p>";
                echo "<p>Email firmy: " . ($user['cea']) . "</p>";
                
                // Dodanie opcji administracyjnych, jeśli użytkownik jest administratorem firmy
                if ($user['is_company_admin'] == 1) {
                    echo "<a href='./add_employee.php'><button>Dodaj pracownika</button</a>";
                    echo "<a href='./view_employee.php'><button>Wyświetl pracowników</botton></a>";
                    echo "<a href='./edit_company.php'><button>Edytuj dane firmy</button></a>";
                }
                echo "</div>";
            }
            echo "<a href='./admin_logout.php' class='button_logout'>Wyloguj się</a>";
            } else {
            echo "<p>Nie znaleziono danych użytkownika.</p>";
            }
            $baza->close();
            } else {
                echo "<p>Musisz być <a href='./login.php'>zalogowany</a>, aby zobaczyć tę stronę.</p>";
            }
        ?>
    </main>
</body>
</html>
