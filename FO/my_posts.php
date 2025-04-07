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
        <title>Secur IT | Moje Wpisy</title>
    </head>
    <body>
        <div class="tlo"></div>
        <main class="main">
            <?php
                include("header.php");
                include("nav.php");
            ?>
            <div class="posts-container">
                <h2>Moje Wpisy</h2>
                <div class="posts-actions">
                    <a href="add_post.php" class="button">Dodaj Nowy Wpis</a>
                </div>
                <?php
                    include('../DB/db_posts.php');
                    $baza = new db_posts();
                    $baza->databaseConnect();
                    
                    $id_user = $_SESSION['id_user'];
                    $data = $baza->selectAllPostsById($id_user);
                    if (!empty($data)){
                ?>
                <div class="tresc">
                <?php
                    while($row = mysqli_fetch_assoc($data))
                    {
                        echo "<div id='wpis' class='artykul'>
                        <h3>".$row['title']."</h3>
                        <p>".$row['content']."</p>
                        <p class='post-date'>".($row['approval_date'] ? $row['approval_date'] : "Oczekuje na zatwierdzenie")."</p>
                        </div>";
                    }
                    }else {
                        echo "<p>Brak wpisów</p>";
                    }
                    $baza->close();
                ?>
                </div>
            </div>
            <?php
                include("footer.php");
            ?>
        </main>
    </body>
</html>
