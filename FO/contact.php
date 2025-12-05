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
        <title>Secur IT | Kontakt</title>
    </head>
    <body class="contact-styles">
        <?php
            include("../DB/db_connection.php");
            include('../DB/db_country_codes.php');
            include('../DB/db_contact.php');
            include('../DB/db_accounts.php');
            $baza = new db_contact();

            if(!empty($_GET)){
                $baza->databaseConnect();
                if(isset($_GET['opcja'])){
                    if($_GET['opcja'] == 'dodaj'){
                        $first_name = $_GET['first_name'];
                        $last_name = $_GET['last_name'];
                        $email = $_GET['email'];
                        $id_country_code = $_GET['id_country_code'];
                        $phone_number = $_GET['phone_number'];
                        $title = $_GET['title'];
                        $message = $_GET['message'];
                        $consent = 0;
                        if(isset($_GET['consent'])){
                            $consent = 1;
                        }
                        $baza->insertContact ($first_name, $last_name, $email, $id_country_code, $phone_number, $title, $message, $consent);
                        if(isset($baza)){
                            switch($baza){
                                case 1:
                                    echo "<script>alert('Wiadomość została wysłana')</script>";
                                    header('location: ./contact.php');
                                    break;
                                default:
                                    header("Location: ./contact.php?echo=".$baza."");
                                    break;
                            }
                        }
                    }
                }
                else{
                    echo "<p>Wiadomość nie została wysłana</p>";
                }
            }    
        ?>
        <div class="tlo"></div>
        <main class="main">
            <?php
                include("nav.php");
            ?>
            <div class="spinaczcenter"> 
                <div class="formularz">
                    <div class="scan-line"></div>
                    <h2>Kontakt</h2>
                    <form id="MyForm" method="get">
                        <?php
                            $isLoggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
                            $userData = [];

                            if ($isLoggedIn) {
                                $id_user = $_SESSION['id_user'];
                                $konto = new db_accounts();
                                $konto->databaseConnect();
                                $result = $konto->selectCustomerById($id_user, null);
                                if ($result && mysqli_num_rows($result) > 0) {
                                    $userData = mysqli_fetch_assoc($result);
                                }
                                $konto->close();
                        ?>
                        <a href="./my_forms.php" class="forms-button">
                            <i class="fa fa-list-alt"></i>
                            Wysłane formularze
                        </a>
                        
                        <label for="useOtherData" class="user-data-toggle">
                            <input type="checkbox" id="useOtherData" onclick="toggleUserData(this)">
                            Użyj innych danych
                        </label>
                        <?php
                            }
                        ?>

                        <div class="left-column">
                            <label for="first_name">Imię:</label>
                            <div class="input-wrapper">
                                <i class="fa fa-user input-icon"></i>
                                <input type="text" placeholder="Imię" name="first_name" id="first_name" alt="pole imię" 
                                       value="<?php echo $isLoggedIn ? ($userData['first_name']) : ''; ?>" 
                                       <?php echo $isLoggedIn ? 'readonly data-default-value="'.($userData['first_name']).'"' : ''; ?> required>
                            </div>
                            
                            <label for="last_name">Nazwisko:</label>
                            <div class="input-wrapper">
                                <i class="fa fa-user-plus input-icon"></i>
                                <input type="text" placeholder="Nazwisko" name="last_name" id="last_name" alt="pole nazwisko"
                                       value="<?php echo $isLoggedIn ? ($userData['last_name']) : ''; ?>" 
                                       <?php echo $isLoggedIn ? 'readonly data-default-value="'.($userData['last_name']).'"' : ''; ?> required>
                            </div>
                            
                            <label for="email">Adres e-mail:</label>
                            <div class="input-wrapper">
                                <i class="fa fa-envelope input-icon"></i>
                                <input type="email" placeholder="Adres e-mail" name="email" id="email" alt="pole e-mail" 
                                       value="<?php echo $isLoggedIn ? ($userData['uea']) : ''; ?>" 
                                       <?php echo $isLoggedIn ? 'readonly data-default-value="'.($userData['uea']).'"' : ''; ?> required>
                            </div>
                            
                            <label for="phone_number">Numer Telefonu:</label>
                            <div class="phonenumber">
                                <?php
                                    
                                    $baza = new db_country_codes();
                                    $baza->databaseConnect();
                                    
                                    if(isset($userData['uicc'])){
                                        $selectedId = $userData["uicc"];
                                    }
                                    else {
                                        $dataPolska = $baza->selectCountryCodesPolska();
                                        if($dataPolska){
                                            while ($row = mysqli_fetch_assoc($dataPolska)){
                                                $selectedId = $row["id_country_code"];
                                            }
                                        }
                                    } 
                                    
                                    $dataCountryCode = $baza->selectCountryCodes();
                                    if ($dataCountryCode){
                                        
                                    echo '<select class="kierunkowy" id="country_code" name="id_country_code" default="">';
                                    while ($row = mysqli_fetch_assoc($dataCountryCode)){
                                        $text = '<option id="pole" class="kierunkowy"';
                                        if($row["id_country_code"] == $selectedId)
                                        {
                                        $text .= ' selected ';
                                        } 
                                        $text .= ' value=' .$row["id_country_code"] .'> ' .$row["country_code"]. " " .$row["country"] .'</option>';

                                        echo $text;
                                    }
                                        echo '</select>';

                                        mysqli_free_result($dataCountryCode);
                                    } else {
                                        echo "Błąd zapytania: " .mysqli_error($connection);
                                    }
                                    
                                    $baza->close();
                                ?>
                                <div class="phone-input-wrapper input-wrapper">
                                    <i class="fa fa-phone input-icon"></i>
                                    <input type="tel" placeholder="Numer Telefonu" name="phone_number" id="phone_number" alt="pole numer telefonu" 
                                       value="<?php echo $isLoggedIn ? ($userData['upn']) : ''; ?>" 
                                       <?php echo $isLoggedIn ? 'readonly data-default-value="'.($userData['upn']).'"' : ''; ?> required>
                                </div>
                            </div>
                        </div>

                        <div class="right-column">
                            <label for="title">Tytuł:</label>
                            <div class="input-wrapper">
                                <i class="fa fa-heading input-icon"></i>
                                <input type="text" placeholder="Tytuł" name="title" id="title" alt="pole tytuł" required>
                            </div>
                            
                            <label for="message">Wiadomość:</label>
                            <div class="input-wrapper">
                                <i class="fa fa-comment textarea-icon"></i>
                                <textarea name="message" placeholder="Treść Wiadomości" id="message" required></textarea>
                            </div>
                            
                            <div class="consent">
                                <label class="custom-checkbox">
                                    <input type="checkbox" name="consent" required>
                                    <span class="checkmark"></span>
                                </label>
                                <span>Wyrażam zgodę na przetwarzanie moich danych osobowych przez firmę Secur IT w celu odpowiedzi na wiadomość skierowaną z wykorzystaniem funkcjonalności strony internetowej secur-it.pl i dalszej wymiany korespondencji oraz oświadczam, 
                                że zapoznałem się z treścią informacji o przetwarzaniu danych osobowych dostępnej w <a href="../documents/polityka_prywatnosci.php">polityce prywatności</a></span>
                            </div>
                            
                            <input type="hidden" name="opcja" id="opcja" value="dodaj">
                            <div class="button-group">
                                <button type="submit" name="submit" class="button">
                                    <i class="fa fa-paper-plane"></i> Wyślij
                                </button>
                                <button type="button" onclick="resetujPola()" class="button">
                                    <i class="fa fa-refresh"></i> Resetuj
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php include("footer.php"); ?>
        </main>
        
        <script>
            function resetujPola() {
                document.getElementById('MyForm').reset();
                document.querySelectorAll('.active-field').forEach(el => {
                    el.classList.remove('active-field');
                });
            }
            
            function toggleUserData(checkbox) {
                const fields = ['first_name', 'last_name', 'email', 'phone_number'];
                
                fields.forEach(field => {
                    const input = document.getElementById(field);
                    if (input) {
                        if (checkbox.checked) {
                            input.removeAttribute('readonly');
                            input.value = '';
                        } else {
                            input.setAttribute('readonly', 'readonly');
                            input.value = input.getAttribute('data-default-value') || '';
                        }
                    }
                });
            }
            
            document.addEventListener('DOMContentLoaded', function() {
                const inputs = document.querySelectorAll('.formularz input, .formularz textarea, .formularz select');
                
                inputs.forEach(input => {
                    input.addEventListener('focus', function() {
                        const icon = this.parentElement.querySelector('.input-icon') || 
                                    this.parentElement.querySelector('.textarea-icon');
                        
                        if (icon) {
                            icon.classList.add('active-field');
                        }
                        
                        const label = document.querySelector(`label[for="${this.id}"]`);
                        if (label) {
                            label.style.color = 'var(--holo-active)';
                            label.style.textShadow = '0 0 5px var(--holo-active)';
                        }
                    });
                    
                    input.addEventListener('blur', function() {
                        const icon = this.parentElement.querySelector('.input-icon') || 
                                    this.parentElement.querySelector('.textarea-icon');
                        
                        if (icon) {
                            icon.classList.remove('active-field');
                        }
                        
                        const label = document.querySelector(`label[for="${this.id}"]`);
                        if (label) {
                            label.style.color = 'var(--holo-primary)';
                            label.style.textShadow = 'none';
                        }
                    });
                });
                
                const formularz = document.querySelector('.formularz');
                
                if (formularz) {
                    document.addEventListener('mousemove', function(e) {
                        const formRect = formularz.getBoundingClientRect();
                        const formCenterX = formRect.left + formRect.width / 2;
                        const formCenterY = formRect.top + formRect.height / 2;
                        
                        const mouseX = e.clientX;
                        const mouseY = e.clientY;
                        
                        // Maksymalny kąt obrotu (w stopniach)
                        const maxRotation = 0.5;
                        
                        const rotateY = maxRotation * (mouseX - formCenterX) / (formRect.width / 2);
                        const rotateX = -maxRotation * (mouseY - formCenterY) / (formRect.height / 2);
                        
                        formularz.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
                    });
                    
                    document.addEventListener('mouseleave', function() {
                        formularz.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg)';
                    });
                }
            });
        </script>
    </body>
</html>