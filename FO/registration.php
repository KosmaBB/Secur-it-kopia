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
        <main class="main" id="main">
            <?php
                include("nav.php");
            ?>
            <div id="loginPage" class="login-container">
                <h2>Rejestracja</h2>
                
                <?php
                if (isset($_GET['echo'])) {
                    $error = $_GET['echo'];
                    echo '<div class="error-message" style="text-align: center; margin-bottom: 20px;">';
                    switch($error) {
                        case 'blad1':
                            echo 'Wystąpił błąd podczas rejestracji. Spróbuj ponownie.';
                            break;
                        case 'blad2':
                            echo 'Nazwa użytkownika jest już zajęta. Wybierz inną.';
                            break;
                        case 'blad3':
                            echo 'Adres email jest już używany. Użyj innego adresu.';
                            break;
                        default:
                            echo 'Wystąpił nieznany błąd. Spróbuj ponownie.';
                    }
                    echo '</div>';
                }
                ?>
                
                <form method="post" action="registration.php" class="registration-form">
                    <div class="form-group">
                        <label>Wybierz typ konta:</label>
                        <div class="inline-radio">
                            <label for="company">
                                <input type="radio" id="company" name="account_type" value="company">
                                Firma
                            </label>
                            <label for="osoba_publiczna">
                                <input type="radio" id="osoba_publiczna" name="account_type" value="osoba_publiczna" checked>
                                Osoba prywatna
                            </label>
                        </div>
                    </div>
                    
                    <div class="company">
                        <div class="form-group-inline">
                            <div>
                                <label for="company_name">Nazwa firmy:</label>
                                <input type="text" id="company_name" name="company_name" placeholder="Wpisz nazwę firmy">
                            </div>
                            <div>
                                <label for="additional_name">Nazwa firmy c.d.:</label>
                                <input type="text" id="additional_name" name="additional_name" placeholder="Wpisz nazwę firmy">
                            </div>
                        </div>
                        <div class="form-group-inline">
                            <div>
                                <label for="tax">NIP:</label>
                                <input type="text" id="tax" name="tax" placeholder="Wpisz NIP firmy">
                            </div>
                            <div>
                                <label for="company_email_address">Email firmy:</label>
                                <input type="email" id="company_email_address" name="company_email_address" placeholder="Wpisz email firmy">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="company_phone_number">Numer telefonu firmy:</label>
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
                        <div>
                            <label for="first_name">Imię:</label>
                            <input type="text" id="first_name" name="first_name" placeholder="Wpisz imię" required>
                        </div>
                        <div>
                            <label for="last_name">Nazwisko:</label>
                            <input type="text" id="last_name" name="last_name" placeholder="Wpisz nazwisko" required>
                        </div>
                    </div>
                    
                    <div class="form-group-inline">
                        <div>
                            <label for="email_address">Email:</label>
                            <input type="email" id="email_address" name="email_address" placeholder="Wpisz email" required>
                        </div>
                        <div>
                            <label for="phone_number">Numer telefonu:</label>
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
                                <input type="text" id="phone_number" name="phone_number" placeholder="Wpisz numer telefonu" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group-inline">
                        <div>
                            <label for="username">Nazwa użytkownika (Nick):</label>
                            <input type="text" id="username" name="username" placeholder="Wpisz nazwę użytkownika" required>
                        </div>
                        <div>
                            <label for="password">Hasło:</label>
                            <input type="password" id="password" name="password" placeholder="Wpisz hasło" required>
                        </div>
                    </div>
                    
                    <button class="button" type="submit">Zarejestruj się</button>
                </form>
            </div>
            <?php include("footer.php"); ?>
        </main>
        
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('holo-sidebar');
            const main = document.getElementById('main');

            const savedState = localStorage.getItem('holoSidebarState');
            if (savedState === 'collapsed') {
                main.classList.add('sidebar-collapsed');
            }

            if (sidebar) {
                const observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                            if (sidebar.classList.contains('collapsed')) {
                                main.classList.add('sidebar-collapsed');
                            } else {
                                main.classList.remove('sidebar-collapsed');
                            }
                        }
                    });
                });
                
                observer.observe(sidebar, { attributes: true });
            }
            
            const companyRadio = document.getElementById('company');
            const personRadio = document.getElementById('osoba_publiczna');
            const companySection = document.querySelector('.company');
            const submitButton = document.querySelector('button[type="submit"]');
            
            function toggleCompanySection() {
                if (companyRadio.checked) {
                    companySection.style.display = 'block';
                    submitButton.textContent = 'Zarejestruj firmę';
                    
                    document.getElementById('company_name').required = true;
                    document.getElementById('tax').required = true;
                    document.getElementById('company_email_address').required = true;
                    document.getElementById('company_phone_number').required = true;
                } else {
                    companySection.style.display = 'none';
                    submitButton.textContent = 'Zarejestruj się';
                    
                    document.getElementById('company_name').required = false;
                    document.getElementById('tax').required = false;
                    document.getElementById('company_email_address').required = false;
                    document.getElementById('company_phone_number').required = false;
                }
            }
            
            toggleCompanySection();
            
            companyRadio.addEventListener('change', toggleCompanySection);
            personRadio.addEventListener('change', toggleCompanySection);
            
            const inputs = document.querySelectorAll('input, select');
            
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.classList.add('input-focus');
                });
                
                input.addEventListener('blur', function() {
                    this.classList.remove('input-focus');
                });
            });
            
            const form = document.querySelector('.registration-form');
            
            form.addEventListener('submit', function(event) {
                let isValid = true;
                
                const password = document.getElementById('password');
                if (password.value.length < 8) {
                    isValid = false;
                    if (!password.nextElementSibling || !password.nextElementSibling.classList.contains('error-message')) {
                        const errorMsg = document.createElement('span');
                        errorMsg.classList.add('error-message');
                        errorMsg.textContent = 'Hasło musi mieć co najmniej 8 znaków';
                        password.parentNode.insertBefore(errorMsg, password.nextSibling);
                    }
                } else if (password.nextElementSibling && password.nextElementSibling.classList.contains('error-message')) {
                    password.nextElementSibling.remove();
                }
                
                const phoneNumber = document.getElementById('phone_number');
                if (!/^\d+$/.test(phoneNumber.value)) {
                    isValid = false;
                    if (!phoneNumber.nextElementSibling || !phoneNumber.nextElementSibling.classList.contains('error-message')) {
                        const errorMsg = document.createElement('span');
                        errorMsg.classList.add('error-message');
                        errorMsg.textContent = 'Numer telefonu może zawierać tylko cyfry';
                        phoneNumber.parentNode.insertBefore(errorMsg, phoneNumber.nextSibling);
                    }
                } else if (phoneNumber.nextElementSibling && phoneNumber.nextElementSibling.classList.contains('error-message')) {
                    phoneNumber.nextElementSibling.remove();
                }
                
                if (companyRadio.checked) {
                    const tax = document.getElementById('tax');
                    if (!/^\d{10}$/.test(tax.value)) {
                        isValid = false;
                        if (!tax.nextElementSibling || !tax.nextElementSibling.classList.contains('error-message')) {
                            const errorMsg = document.createElement('span');
                            errorMsg.classList.add('error-message');
                            errorMsg.textContent = 'NIP musi składać się z 10 cyfr';
                            tax.parentNode.insertBefore(errorMsg, tax.nextSibling);
                        }
                    } else if (tax.nextElementSibling && tax.nextElementSibling.classList.contains('error-message')) {
                        tax.nextElementSibling.remove();
                    }
                }
                
                if (!isValid) {
                    event.preventDefault();
                }
            });
        });
    </script>
    </body>
</html>