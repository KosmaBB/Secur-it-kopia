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
        <title>Secur IT | Edytuj Wpis</title>
    </head>
    <body>
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
                $id_post = $_GET['id_post'];
                $title = $_GET['title'];
                $content = $_GET['content'];
                $id_approving_employee = null;
                $approval_date = null;
                $baza->updatePost($id_post, $_SESSION['id_user'], $title, $content, date("Y-m-d H:i:s"),$id_approving_employee, $approval_date);
            }
            ?>
            <form action="edit_post.php">
                <input type="hidden" name="id_post" value="<?php echo $_GET['id_post']; ?>">
                <label for="title">Tytuł wpisu:</label><br>
                <input type="text" name="title" placeholder="Wpisz tytuł" maxlength="200" required><br>
                <label for="content">Treść wpisu:</label><br>
                <textarea name="content" placeholder="Wpisz treść wpisu" required></textarea>
                <button type="submit" class="btn-submit">Edytuj Wpis</button>
            </form>
        </main>
    </body>
</html>
