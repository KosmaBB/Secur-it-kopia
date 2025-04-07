<header class="header">
    <?php
        include_once('../DB/db_accounts.php');
        if(!isset($_SESSION['sesja'])){
            session_start();
            $_SESSION['sesja'] = "test";
        }
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
            $id_user = $_SESSION['id_user'];

            $baza = new db_accounts();
            $baza->databaseConnect();
            $data = $baza->selectCustomerById($id_user, null);

            if ($data && mysqli_num_rows($data) > 0) {
                $user = mysqli_fetch_assoc($data);
                echo "<div class='header-content'>";
                echo "<a href='./account.php' class='header-link'><i class='fa-solid fa-user'></i> ";
                echo ($user['username']);
                echo "</a><a href='./logout.php' class='header-link'><i class='fa-solid fa-arrow-right-from-bracket'></i>Wyloguj się</a>";
                echo "<a href='basket.php' class='header-link'><i class='fa-solid fa-basket-shopping'></i>Koszyk</a>";
                echo "</div>";
            }
            $baza->close();
        }
        else{
            echo "<div class='header-content'>";
            echo "<a href='./registration.php' class='header-link'><i class='fa-solid fa-user-plus'></i>Rejestracja</a>";
            echo "<a href='./login.php' class='header-link'><i class='fa-solid fa-user'></i>Logowanie</a>";
            echo "</div>";
        }
    ?>
</header>
