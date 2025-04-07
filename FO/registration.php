<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    include_once ('../include/functions.php');
    include_once('../DB/db_accounts.php');
    $baza = new db_accounts();
    $baza->databaseConnect();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $account_type = $_POST['account_type'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $company_name = ($account_type == 'company') ? $_POST['company_name'] : '';
        $additional_name = ($account_type == 'company') ? $_POST['additional_name'] : '';
        $tax = ($account_type == 'company') ? $_POST['tax'] : '';
        $username = $_POST['username'];
        $email_address = $_POST['email_address'];
        $company_email_address = $_POST['company_email_address'];
        $id_country_code = $_POST['id_country_code'];
        $id_company_country_code = $_POST['id_company_country_code'];
        $company_phone_number = $_POST['company_phone_number'];
        $phone_number = $_POST['phone_number'];
        $password = sha1($_POST['password']);
        
        // Obsługa zapisu danych do bazy
        $return = $baza->registerCustomer($first_name, $last_name, $username, $password, $id_country_code,  $phone_number, $email_address, $company_name, $additional_name, $tax, $id_company_country_code, $company_phone_number, $company_email_address);
        if(isset($return)){
            switch($return) {
                case 1:
                    header("Location: ./login.php");
                    break;
                case 2:
                    header("Location: ./registration.php?echo=blad1");
                    echo "Bład strony";
                    break;
                case 3:
                    header("Location: ./registration.php?echo=blad2");
                    break;
                case 4:
                    header("Location: ./registration.php?echo=blad3");
                    break;
                default:
                    header("Location: ./registration.php?echo=".$return."");
                    break;
            }
        } else {
            header("Location: ./registration.php?echo=else");
        }
        exit();
    }
?>
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://kit.fontawesome.com/1deffa5961.js" crossorigin="anonymous"></script>
        <link rel="shortcut icon" href="../images/ikona.png">
        <title>Secur IT | Rejestracja</title>
    </head>
    <body>
        <div class="tlo"></div>
        <main class="main">
            <?php
                include("header.php");
                include("nav.php");
                include("footer.php");
            ?>
            <div id="loginPage" class="login-container">
                <h2>Rejestracja</h2>
                <form method="post" action="registration.php" class="registration-form">
                    <div class="form-group">
                        <label for="account_type">Wybierz typ konta:</label>
                        <div class="inline-radio">
                            <input type="radio" id="company" name="account_type" value="company">
                            <label for="company">Firma</label>
                            <input type="radio" id="osoba_publiczna" name="account_type" value="osoba_publiczna" checked>
                            <label for="osoba_publiczna">Osoba prywatna</label>
                        </div>
                        <div class="company">
                            <div class="form-group-inline">
                                <label for="company_name">Nazwa firmy:</label>
                                <input type="text" id="company_name" name="company_name" placeholder="Wpisz nazwę firmy">
                                <label for="additional_name">Nazwa firmy c.d.:</label>
                                <input type="text" id="additional_name" name="additional_name" placeholder="Wpisz nazwę firmy">
                            </div>
                            <div class="form-group-inline">
                                <label for="tax">NIP:</label>
                                <input type="text" id="tax" name="tax" placeholder="Wpisz NIP firmy">
                                <label for="company_email_address">Email firmy:</label>
                                <input type="email" id="company_email_address" name="company_email_address" placeholder="Wpisz email firmy">
                            </div>
                            <div class="form-group-inline">
                                <label for="company_phone_number" id="company_phone_number_txt">Numer telefonu firmy:</label>
                                <div class="phone_number">
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
                                            echo '<select class="kierunkowy" name="id_company_country_code" default="">';
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
                                            mysqli_free_result($data);
                                        } 
                                        else 
                                        {
                                            echo "Błąd zapytania: " .mysqli_error($connect);
                                        }
                                        $baza->close();
                                    ?>
                                    <input type="text" id="company_phone_number" name="company_phone_number" placeholder="Wpisz numer telefonu firmy">  
                                </div>
                            </div>
                        </div>
                        <div class="form-group-inline">
                            <label for="first_name">Imię:</label>
                            <input type="text" id="first_name" name="first_name" placeholder="Wpisz imię">
                            <label for="last_name">Nazwisko:</label>
                            <input type="text" id="last_name" name="last_name" placeholder="Wpisz nazwisko">
                        </div>
                        <div class="form-group-inline">
                            <label for="email_address">Email:</label>
                            <input type="email" id="email_address" name="email_address" placeholder="Wpisz email" required>
                            <label for="phone_number" id="phone_number_txt">Numer telefonu:</label>
                            <div class="phone_number">
                                <?php
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
                                        echo '<select class="kierunkowy" name="id_country_code" default="">';
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
                                        mysqli_free_result($data);
                                    } 
                                    else 
                                    {
                                        echo "Błąd zapytania: " .mysqli_error($connect);
                                    }
                                    $baza->close();
                                ?>
                                <input type="text" id="phone_number" name="phone_number" placeholder="Wpisz numer telefonu:" required>
                            </div>
                        </div>
                        <div class="form-group-inline">
                            <label for="username">Nazwa użytkownika (Nick):</label>
                            <input type="text" id="username" name="username" placeholder="Wpisz nazwę użytkownika" required>
                            <label for="password">Hasło:</label>
                            <input type="password" id="password" name="password" placeholder="Wpisz hasło" required>
                        </div>
                        <button class="button" type="submit">Zarejestruj firmę</button>
                    </div>
                </form>
            </div>
        </main>
        <script src="./script.js"></script>
    </body>
</html>
