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
        <title>Secur IT | Usługi - Wpisy</title>
    </head>
    <body>
        <div class="tlo"></div>
        <main class="main">
            <?php
                include("header.php");
                include("nav.php");
                include("footer.php");
            ?>
            <div class="posts-container">
                <?php
                    include('../DB/db_posts.php');
                    $baza = new db_posts();
                    $baza->databaseConnect();
                    
                    if($id_user !== 0){
                        echo "<div class='posts-actions'>";
                        echo "<a href='add_post.php' class='button'>Dodaj Wpis</a>";
                        echo "<a href='my_posts.php' class='button'>Moje Wpisy</a>";
                        echo "</div>";
                    };
                    
                    $data = $baza->selectCheckedPost();
                    if (!empty($data)){
                ?>
                <div class="tresc">
                <?php
                    while($row = mysqli_fetch_assoc($data))
                    {
                        echo "<div class='artykul'>";
                        echo "<h3>".$row['title']."</h3>";
                        echo "<p>".$row['content']."</p>";
                        echo "<span class='post-date'>".$row['approval_date']."</span>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>Brak wpisów</p>";
                }
                $baza->close();
                ?>
                </div>
            </div>
        </main>
    </body>
</html>