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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone_number = $_POST['phone_number'];
    $email_address = $_POST['email_address'];
    $username = $_POST['username'];

    if ($baza->checkExistingUser($phone_number, $username, $id_user)) {
        echo "<p>Użytkownik z takim numerem telefonu lub nazwą użytkownika już istnieje.</p>";
    } else {
        if ($baza->updateUserDetails($id_user, $first_name, $last_name, $phone_number, $email_address, $username)) {
            echo "<p>Dane zostały zaktualizowane.</p>";
        } else {
            echo "<p>Wystąpił błąd podczas aktualizacji danych.</p>";
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
    <title>Edytuj dane konta</title>
</head>
<body>
    <div class="tlo"></div>
    <main class="main">
        <?php
            include("header.php");
            include("nav.php");
            include("footer.php");
        ?>
        <div class="edit-account-container">
            <h2>Edytuj dane konta</h2>
            <form method="post" action="edit_account.php" class="edit-account-form">
                <div class="form-group">
                    <label for="first_name">Imię:</label>
                    <input type="text" id="first_name" name="first_name" value="<?php echo $user['first_name']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="last_name">Nazwisko:</label>
                    <input type="text" id="last_name" name="last_name" value="<?php echo $user['last_name']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="phone_number">Numer telefonu:</label>
                    <input type="text" id="phone_number" name="phone_number" value="<?php echo $user['upn']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="email_address">Email:</label>
                    <input type="email" id="email_address" name="email_address" value="<?php echo $user['uea']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="username">Nazwa użytkownika:</label>
                    <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>" required>
                </div>
                <button type="submit" class="button">Zapisz zmiany</button>
                <a href="account.php" class="button back-button">Powrót do konta</a>
            </form>
        </div>
    </main>
</body>
</html>
