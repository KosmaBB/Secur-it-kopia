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
        <title>Secur IT | Dodaj Pracownika</title>
    </head>
    <body>
        <main class="main">
            <?php

                include("nav.php");
                include("footer.php");
            ?>

            <?php
                include_once('../DB/db_accounts.php');

                if (!isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == false) {
                    header("Location: ./login.php");
                    exit();
                }
                
                $id_company = $_SESSION['id_company'];
                $baza = new db_accounts();
                $baza->databaseConnect();

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $first_name = $_POST['first_name'];
                    $last_name = $_POST['last_name'];
                    $username = $_POST['username'];
                    $email_address = $_POST['email_address'];
                    $id_country_code = $_POST['country_code'];
                    $phone_number = $_POST['phone_number'];
                    $password = sha1($_POST['password']);
                    $is_company_admin = 0;

                    $query = $baza->registerCustomer($first_name, $last_name, $username, $password, $id_country_code,  $phone_number, $email_address, '', '', '', '', '', '', $id_company, $is_company_admin);
                    
                    if ($query == 1) {
                        echo "Pracownik został dodany pomyślnie.";
                    } else {
                        echo "Wystąpił błąd podczas dodawania pracownika.";
                    }
                }
            ?>
            <a href="./account.php"><button>Powrót</button></a>
            <div id="addEmployeePage" class="add-employee-container">
                <h2>Dodaj Pracownika</h2>
                <form method="post" action="add_employee.php" class="employee-form">
                    <div class="form-group">
                        <label for="first_name">Imię:</label>
                        <input type="text" id="first_name" name="first_name" placeholder="Wpisz imię" required><br>
                        
                        <label for="last_name">Nazwisko:</label>
                        <input type="text" id="last_name" name="last_name" placeholder="Wpisz nazwisko" required><br>
                        
                        <label for="username">Nazwa użytkownika (Nick):</label>
                        <input type="text" id="username" name="username" placeholder="Wpisz nazwę użytkownika" required><br>
                        
                        <label for="email_address">Email:</label>
                        <input type="email" id="email_address" name="email_address" placeholder="Wpisz email" required><br>
                        <label for="phone_number" id="phone_number_txt" >Numer telefonu:</label>
                        <?php
                            include('../DB/db_country_codes.php');
                            $baza = new db_country_codes();
                            $baza->databaseConnect();
                            
                            $dataPolska = $baza->selectCountryCodesPolska();
                            if ($dataPolska){
                                while ($row = mysqli_fetch_assoc($dataPolska)){
                                    $selectedId = $row["id_country_code"];
                                } 
                            }
                            
                            $data = $baza->selectCountryCodes();
                            if ($data)
                            {
                                echo '<div class="phone_number">';
                                echo '<select class="kierunkowy" name="country_code" default="">';
                                while ($row = mysqli_fetch_assoc($data))
                                {
                                    $text = '<option id="pole" class="kierunkowy"';
                                    if($row["id_country_code"] == $selectedId)
                                    {
                                    $text .= 'selected = "selected"';
                                    } 
                                    $text .= ' value=' .$row["id_country_code"] .'> ' .$row["country_code"]. " " .$row["country"] .'</option>';

                                    echo $text;
                                }
                                echo '</select>';
                                echo '</div>';
                                mysqli_free_result($data);
                            } 
                            else 
                            {
                                echo "Błąd zapytania: " .mysqli_error($connect);
                            }
                            $baza->close();
                        ?>
                        <input type="text" id="phone_number" name="phone_number" placeholder="Wpisz numer telefonu"><br>
                        <label for="password">Hasło:</label>
                        <input type="password" id="password" name="password" placeholder="Wpisz hasło" required><br>
                        <button class="button" type="submit">Dodaj pracownika</button>
                    </div>
                </form>
            </div>
        </main>
        <script src="./script.js"></script>
    </body>
</html>
