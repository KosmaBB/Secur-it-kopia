<?php
    include_once ('../include/functions.php');
    include('../DB/db_about_company.php');

    if ($id_employee == 0){
        header('Location: ../FO/account.php');
    }

    $baza = new db_about_company();
    $baza->databaseConnect();

    if(isset($_GET['id_about_company'])){
        $id_about_company = $_GET['id_about_company'];
        $row = $baza->getAbout_companyById($id_about_company);
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $id_about_company = $_POST['id_about_company'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $baza->updateAbout_company($id_about_company, $title, $description);
        header('Location: admin_about_company.php');
    }

    $baza->close();
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
    <title>Secur IT | Admin - Edytuj O Firmie</title>
</head>
<body>
    <div class="tlo"></div>
    <main class="main">
        <?php
            include("./admin_header.php");
            include("./admin_nav.php");
        ?>
        <div class="tresc">
            <form class="formularz" method="POST" action="admin_edit_about_company.php">
                <h2 class="center-text">Edytuj Wpis</h2>
                <input type="hidden" name="id_about_company" value="<?php echo $row['id_about_company']; ?>">
                <label for="title">Tytuł:</label>
                <input type="text" id="title" name="title" value="<?php echo $row['title']; ?>" required>
                <label for="description">Opis:</label>
                <textarea id="description" name="description" rows="10" required><?php echo $row['description']; ?></textarea>
                <button type="submit" class="button">Zapisz zmiany</button>
            </form>
        </div>
    </main>
</body>
</html>
