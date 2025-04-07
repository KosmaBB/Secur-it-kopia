<?php
    include_once ('../include/functions.php');

    if ($id_employee == 0){
        header('Location: ../FO/account.php');
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['approve_post'])) {
        include_once('../DB/db_posts.php');
        $baza = new db_posts();
        $baza->databaseConnect();
        $id_post = $_POST['id_post'];
        $approval_date = date('Y-m-d H:i:s');
        $baza->updateAprovePost($id_post, $id_employee, $approval_date);
        $baza->close();
        header("Location: admin_posts.php");
        exit();
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
        <title>Secur IT | Admin Wpisy</title>
    </head>
    <body>
        <div class="tlo"></div>
        <main class="main">
            <?php
                include("./admin_header.php");
                include("./admin_nav.php");
                include_once('../DB/db_posts.php');

                $baza = new db_posts();
                $baza->databaseConnect();
                $data = $baza->selectUnApprovedPost();
                if (!empty($data)) {
                    echo "<div class='posts-container'>";
                    while ($row = mysqli_fetch_assoc($data)) {
                        echo "<div class='post-card'>
                            <h3>" . htmlspecialchars($row['title']) . "</h3>
                            <p><strong>Nick:</strong> " . htmlspecialchars($row['username']) . "</p>
                            <p><strong>Tytuł:</strong> " . htmlspecialchars($row['title']) . "</p>
                            <p><strong>Treść:</strong> " . htmlspecialchars($row['content']) . "</p>
                            <p><strong>Data dodania:</strong> " . htmlspecialchars($row['date_added']) . "</p>
                            <form method='POST' class='approve-form'>
                                <input type='hidden' name='id_post' value='" . htmlspecialchars($row['id_user']) . "'>
                                <button type='submit' name='approve_post' class='button approve-button'>Zatwierdź wpis</button>
                            </form>
                        </div>";
                    }
                    echo "</div>";
                } else {
                    echo "<p class='empty-message'>Brak niezatwierdzonych wpisów.</p>";
                }
            ?>
        </main>
    </body>
</html>