<?php
include_once('../include/functions.php');
include_once('../DB/db_accounts.php');
session_start();

if ($_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id_user'];
$baza = new db_accounts();
$baza->databaseConnect();
$data = $baza->selectCustomerById($id_user, null);

if ($data && mysqli_num_rows($data) > 0) {
    $user = mysqli_fetch_assoc($data);
} else {
    echo "<p>Nie znaleziono danych użytkownika.</p>";
    exit;
}

$message = '';
$messageType = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone_number = $_POST['phone_number'];
    $email_address = $_POST['email_address'];
    $username = $_POST['username'];

    if ($baza->checkExistingUser($phone_number, $username, $id_user)) {
        $message = "Użytkownik z takim numerem telefonu lub nazwą użytkownika już istnieje.";
        $messageType = "error";
    } else {
        if ($baza->updateUserDetails($id_user, $first_name, $last_name, $phone_number, $email_address, $username)) {
            $message = "Dane zostały zaktualizowane pomyślnie.";
            $messageType = "success";
        } else {
            $message = "Wystąpił błąd podczas aktualizacji danych.";
            $messageType = "error";
        }
    }
}
$baza->close();
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
    <title>Secur IT | Edytuj dane konta</title>
</head>
<body>
    <div class="holo-background">
        <div class="holo-grid-lines"></div>
        <div class="holo-particles"></div>
    </div>
    
    <main class="main">
        <?php
            include("nav.php");
        ?>
        
        <div class="holo-edit-account-container">
            <div class="holo-scan-line"></div>
            <h2 class="holo-edit-account-title">Edytuj dane konta</h2>
            
            <?php if (!empty($message)): ?>
                <div class="holo-message <?php echo $messageType; ?>">
                    <i class="fa <?php echo $messageType === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'; ?> holo-message-icon"></i>
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            
            <form method="post" action="edit_account.php" class="holo-edit-account-form">
                <div class="holo-form-group">
                    <label for="first_name">Imię</label>
                    <input type="text" id="first_name" name="first_name" value="<?php echo $user['first_name']; ?>" required>
                </div>
                
                <div class="holo-form-group">
                    <label for="last_name">Nazwisko</label>
                    <input type="text" id="last_name" name="last_name" value="<?php echo $user['last_name']; ?>" required>
                </div>
                
                <div class="holo-form-group">
                    <label for="phone_number">Numer telefonu</label>
                    <input type="text" id="phone_number" name="phone_number" value="<?php echo $user['upn']; ?>" required>
                </div>
                
                <div class="holo-form-group">
                    <label for="email_address">Email</label>
                    <input type="email" id="email_address" name="email_address" value="<?php echo $user['uea']; ?>" required>
                </div>
                
                <div class="holo-form-group">
                    <label for="username">Nazwa użytkownika</label>
                    <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>" required>
                </div>
                
                <div class="holo-buttons-container">
                    <button type="submit" class="holo-button">
                        <i class="fa fa-save"></i>
                        <span>Zapisz zmiany</span>
                    </button>
                    
                    <a href="account.php" class="holo-button secondary">
                        <i class="fa fa-arrow-left"></i>
                        <span>Powrót do konta</span>
                    </a>
                </div>
            </form>
        </div>
        
        <?php
            include("footer.php");
        ?>
    </main>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.querySelector('.holo-edit-account-container');
            container.style.opacity = '0';
            container.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                container.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                container.style.opacity = '1';
                container.style.transform = 'translateY(0)';
            }, 100);
            
            const message = document.querySelector('.holo-message');
            if (message) {
                setTimeout(() => {
                    message.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    message.style.opacity = '0';
                    message.style.transform = 'translateY(-10px)';
                    
                    setTimeout(() => {
                        message.style.display = 'none';
                    }, 500);
                }, 5000);
            }
        });
    </script>
</body>
</html>