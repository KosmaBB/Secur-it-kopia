<?php
    include_once ('../include/functions.php');
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
        <title>Secur IT | Logowanie</title>
    </head>
    <body>
    <?php
        include_once('../DB/db_accounts.php');
        if(!isset($_SESSION['sesja'])){
            session_start();
        }
        $baza = new db_accounts();
        $baza->databaseConnect();

        if (isset($_POST['username'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $encrypted = sha1($password);
            $data = $baza->selectCustomer($username, $encrypted);

            if ($data && mysqli_num_rows($data) > 0) {
                $user = mysqli_fetch_assoc($data);
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;
                $_SESSION['id_user'] = $user['id_user'];
                $_SESSION['id_company'] = $user['id_company'];
                $_SESSION['is_admin'] = $user['is_admin'];
                $_SESSION['id_employee'] = $user['id_employee'];
                
                header("Location: ./account.php");
            } else {
                $_SESSION['loggedin'] = false;
                $error_message = "Nieprawidłowa nazwa użytkownika lub hasło.";
            }
        }
    ?>

        <div class="tlo"></div>
        <main class="main" id="main">
            <?php
                include("nav.php");
            ?>
            <div id="loginPage" class="login-container">
                <h2>Logowanie do systemu</h2>

                <?php
                if (isset($error_message)) {
                    echo '<p style="color: red;">' . $error_message . '</p>';
                }
                $baza->close();
                ?>
                <form method="POST" class="login-form">
                    <div class="form-group">
                        <label for="username">Nazwa użytkownika:</label>
                        <input type="text" id="username" name="username" placeholder="Wprowadź nazwę użytkownika" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Hasło:</label>
                        <input type="password" id="password" name="password" placeholder="Wprowadź hasło" required>
                    </div>
                    <div class="form-group">
                        <button class="button" type="submit">
                            <i class="fa fa-sign-in"></i> Zaloguj się
                        </button>
                        <a class="button" href="./registration.php">
                            <i class=""></i> Nie masz jeszcze konta?
                        </a>
                    </div>
                </form>
            </div>
            <?php include("footer.php"); ?>
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
                const inputs = document.querySelectorAll('.form-group input');
                
                inputs.forEach(input => {
                    input.addEventListener('focus', function() {
                        this.parentElement.classList.add('input-focus');
                    });
                    
                    input.addEventListener('blur', function() {
                        this.parentElement.classList.remove('input-focus');
                    });
                });
            });
        </script>
    </body>
</html>