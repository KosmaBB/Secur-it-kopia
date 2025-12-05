<?php
    include_once ('../include/functions.php');
    include('../DB/db_companies.php');

    $baza = new db_companies();
    $baza->databaseConnect();

    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        $id_user = $_SESSION['id_user'];
    }
    if (isset($_SESSION['id_company'])) {
        $id_company = $_SESSION['id_company'];
        $data = $baza->selectCompanyByID($id_company);
        $company = mysqli_fetch_assoc($data);
    } else {
        echo "Error: No company ID specified.";
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
        $company_name = $_POST['company_name'];
        $additional_name = $_POST['additional_name'];
        $tax = $_POST['tax'];
        $id_country_code = $_POST['id_country_code'];
        $phone_number = $_POST['phone_number'];
        $email_address = $_POST['email_address'];

        $baza->updateCompany($id_company, $company_name, $additional_name, $tax, $id_country_code, $phone_number, $email_address);
    }
    $baza->close();
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
        <title>Secur IT | Edytuj Dane Firmy</title>
    </head>
    <body>
        <div class="tlo"></div>
        <main class="main">
            <?php 

                include("nav.php");
                include("footer.php");
            ?>

            <div class="edit-company-container">
                <h2>Edytuj Dane Firmy</h2>
                <form action="edit_company.php?id_firma=<?php echo $id_company; ?>" method="post" class="edit-company-form">
                    <div class="form-group">
                        <label for="company_name">Nazwa firmy:</label>
                        <input type="text" id="company_name" name="company_name" value="<?php echo $company['company_name']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="additional_name">Nazwa firmy cd:</label>
                        <input type="text" id="additional_name" name="additional_name" value="<?php echo $company['additional_name']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="tax">NIP:</label>
                        <input type="text" id="tax" name="tax" value="<?php echo $company['tax']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="id_country_code">Numer kierunkowy:</label>
                        <?php
                            include('../DB/db_country_codes.php');
                            $baza_numery = new db_country_codes();
                            $baza_numery->databaseConnect();

                            $selectedId = $company['id_country_code']; 
                            $data = $baza_numery->selectCountryCodes();
                            if ($data) {
                                echo '<select class="kierunkowy" name="id_country_code">';
                                while ($row = mysqli_fetch_assoc($data)) {
                                    $text = '<option value="' . $row["id_country_code"] . '"';
                                    if ($row["id_country_code"] == $selectedId) {
                                        $text .= ' selected="selected"';
                                    }
                                    $text .= '>' .$row["country_code"]. " " .$row["country"] .'</option>';
                                    echo $text;
                                }
                                echo '</select>';
                                mysqli_free_result($data);
                            } else {
                                echo "Błąd zapytania: " . mysqli_error($connect);
                            }
                            $baza_numery->close();
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="phone_number">Numer telefonu:</label>
                        <input type="text" id="phone_number" name="phone_number" value="<?php echo $company['phone_number']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email_address">Adres e-mail:</label>
                        <input type="email" id="email_address" name="email_address" value="<?php echo $company['email_address']; ?>" required>
                    </div>
                    <button type="submit" name="update" class="button">Zaktualizuj dane</button>
                    <a href="./account.php" class="button back-button">Powrót</a>
                </form>
            </div>
        </main>
    </body>
</html>
