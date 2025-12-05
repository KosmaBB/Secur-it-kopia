<?php
    include_once ('../include/functions.php');
    include_once('../DB/db_accounts.php');
    session_start();

    if ($_SESSION['loggedin'] !== true) {
        header("Location: ./login.php");
        exit;
    }

    $error_message = '';
    $success_message = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_user = $_SESSION['id_user'];
        $old_password = $_POST['old_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        $baza = new db_accounts();
        $baza->databaseConnect();
        $data = $baza->selectCustomerById($id_user, null);

        if ($data && mysqli_num_rows($data) > 0) {
            $user = mysqli_fetch_assoc($data);
            if (sha1($old_password) === $user['password']) {
                if ($new_password === $confirm_password) {
                    $encrypted_new_password = sha1($new_password);
                    $baza->updateCustomerPassword($id_user, $encrypted_new_password);
                    $success_message = "Hasło zostało zmienione pomyślnie.";
                } else {
                    $error_message = "Nowe hasło musi się zgadzać.";
                }
            } else {
                $error_message = "Stare hasło jest niepoprawne.";
            }
        }
        $baza->close();
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
        <title>Secur IT | Zmień hasło</title>
    </head>
    <body>
        <div class="tlo"></div>
        <main class="main">
            <?php
                include("nav.php");
            ?>
            <div id="changePasswordPage" class="change-password-container">
                <h2>Zmień hasło</h2>
                <?php
                if ($error_message) {
                    echo '<p style="color: red;">' . $error_message . '</p>';
                }
                if ($success_message) {
                    echo '<p style="color: green;">' . $success_message . '</p>';
                }
                ?>
                <form method="POST" class="change-password-form">
                    <div class="form-group">
                        <label for="old_password">Stare hasło:</label>
                        <input type="password" id="old_password" name="old_password" placeholder="Enter your old password" required>
                    </div>
                    <div class="form-group">
                        <label for="new_password">Nowe hasło:</label>
                        <input type="password" id="new_password" name="new_password" placeholder="Enter your new password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Potwierdź nowe hasło:</label>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your new password" required>
                    </div>
                    <div class="form-group">
                        <button class="button" type="submit">Zmień hasło</button><br><br>
                        <a class="button" href="./account.php">Powrót do konta</a>
                    </div>
                </form>
            </div>
            <?php
                include("footer.php");
            ?>
        </main>
    </body>
</html>
