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
        <title>Secur IT | Usługi - Dodaj Wpis</title>
    </head>
    <body>
        <div class="tlo"></div>
        <main class="main">
            <?php
                include("header.php");
                include("nav.php");
                include("footer.php");
            ?>
            <?php
            include('../DB/db_posts.php');
            $baza = new db_posts();
            if(!empty($_GET)){
                $baza->databaseConnect();
                $id_user = $_SESSION['id_user'];
                $title = $_GET['title'];
                $content = $_GET['content'];
                $date_added =  date("Y-m-d H:i:s");
                $baza->insertPost ($id_user, $title, $content, $date_added);
            }
            ?>
            <div class="add-post-container">
                <h2>Dodaj Nowy Wpis</h2>
                <form action="add_post.php" method="get" class="add-post-form">
                    <div class="form-group">
                        <label for="title">Tytuł wpisu:</label>
                        <input type="text" id="title" name="title" placeholder="Wpisz tytuł" maxlength="200" required>
                    </div>
                    <div class="form-group">
                        <label for="content">Treść wpisu:</label>
                        <textarea id="content" name="content" placeholder="Wpisz treść wpisu" required></textarea>
                    </div>
                    <button type="submit" class="button">Dodaj Wpis</button>
                </form>
            </div>
        </main>
    </body>
</html>