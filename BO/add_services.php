<?php
include_once('../include/functions.php');
include_once('../DB/db_services.php');

if ($id_employee == 0) {
    header('Location: ../FO/account.php');
    exit;
}

$baza = new db_services();
$baza->databaseConnect();

if (!empty($_GET)) {
    $id_service_type = $_GET['id_service_type'];
    $name = $_GET['name'] ?? '';
    $description = $_GET['description'];
    $price = $_GET['price'];

    $baza->insertServices($id_service_type, $name, $description, $price);
    exit;
}

$service_types = $baza->SelectServiceType();
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
    <title>Secur IT | Dodaj Usługę</title>
</head>
<body>
    <div class="tlo"></div>
    <main class="main">
        <?php
        include("./admin_header.php");
        include("./admin_nav.php");
        ?>
        <section class="modern-form">
            <h1 class="center-text">Dodaj Nową Usługę</h1>
            <form action="add_service.php" method="GET" class="form-add-service">
                <label for="id_service_type">Typ usługi:</label>
                <select name="id_service_type" id="id_service_type" required>
                    <option value="" disabled selected>Wybierz typ usługi</option>
                    <?php
                    while ($row = mysqli_fetch_assoc($service_types)) {
                        echo "<option value='{$row['id_service_type']}'>{$row['service_type']}</option>";
                    }
                    ?>
                </select>

                <label for="name">Nazwa:</label>
                <input type="text" name="name" id="name" placeholder="Wprowadź nazwę usługi" required>

                <label for="description">Opis:</label>
                <textarea name="description" id="description" rows="5" placeholder="Wprowadź opis usługi" required></textarea>

                <label for="price">Cena:</label>
                <input type="number" name="price" id="price" placeholder="Wprowadź cenę" step="0.01" required>

                <button type="submit" class="modern-button">Dodaj Usługę</button>
            </form>
        </section>
    </main>
</body>
</html>
