<?php
    include_once('../include/functions.php');
    include_once('../DB/db_employees.php');

    if ($id_employee == 0) {
        header('Location: ../FO/account.php');
        exit;
    }

    $baza = new db_employees();
    $baza->databaseConnect();

    if (!empty($_POST)) {
        $contract_number = $_POST['contract_number'];
        $id_contract_type = $_POST['id_contract_type'];
        $PESEL = $_POST['PESEL'] ?? '';
        $insurance_number = $_POST['insurance_number'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $salary = $_POST['salary'];
        $bonus = $_POST['bonus'] ?? NULL;
        $id_position = $_POST['id_position'];
        $id_work_location = $_POST['id_work_location'];
        $id_department = $_POST['id_department'];
        $home_address = $_POST['home_address'];
        $date_of_birth = $_POST['date_of_birth'];
        $id_car = $_POST['id_car'] ?? NULL;
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $id_country_code = $_POST['id_country_code'];
        $phone_number = $_POST['phone_number'];
        $email_address = $_POST['email_address'];
        $username = $_POST['username'];
        $password = sha1($_POST['password']);

        // Obsługa zdjęcia
        $photo_path = null;
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
            // Sprawdzamy czy plik jest zdjęciem
            $photo = $_FILES['photo'];
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
            $file_extension = pathinfo($photo['name'], PATHINFO_EXTENSION);
            
            if (in_array(strtolower($file_extension), $allowed_extensions)) {
                $new_filename = $first_name . '_' . $last_name . '.' . $file_extension;
                $upload_dir = '../images/pracownicy/';
                
                // Sprawdzamy, czy katalog istnieje, jeśli nie to go tworzymy
                if (!is_dir($upload_dir)) { 
                    mkdir($upload_dir, 0777, true);
                }
                
                $upload_path = $upload_dir . $new_filename;

                // Przenosimy plik do katalogu
                if (move_uploaded_file($photo['tmp_name'], $upload_path)) {
                    // Możesz zapisać ścieżkę do zdjęcia w bazie danych, jeśli jest taka potrzeba
                    $photo_path = $upload_path;
                } else {
                    echo "Błąd podczas przesyłania zdjęcia.";
                    exit;
                }
            } else {
                echo "Dozwolone są tylko pliki graficzne (jpg, jpeg, png, gif).";
                exit;
            }
        }

        $baza->insertPracownik ($contract_number, $id_contract_type, $PESEL, $insurance_number, $start_date, $end_date, $salary, $bonus, $id_position, $id_work_location, $id_department, $home_address, $date_of_birth, $photo_path, $id_car, $first_name, $last_name, $id_country_code, $phone_number, $email_address, $username, $password);
        exit;
    }

    $positions = $baza->SelectPositions();
    $work_locations = $baza->SelectWorkLocations();
    $departments = $baza->SelectDepartments();
    $cars = $baza->SelectCars();
    $contract_types = $baza->SelectContractsTypes();
?>

<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./admin.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="./admin.js" defer></script>
        <script src="https://kit.fontawesome.com/1deffa5961.js" crossorigin="anonymous"></script>
        <link rel="shortcut icon" href="../images/ikona.png">
        <title>Secur IT | Dodaj Pracownika</title>
    </head>
    <body>
        <?php
            include("./admin_header.php");
            include("./admin_nav.php");
        ?>
        <main class="main">
            <section class="formularz modern-form">
                <h1 class="center-text">Dodaj Pracownika</h1>
                <form action="add_employee.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="first_name">Imię:</label>
                        <input type="text" name="first_name" id="first_name" placeholder="Wprowadź imię pracownika" required>
                    </div>
                    <div class="form-group">
                        <label for="last_name">Nazwisko:</label>
                        <input type="text" name="last_name" id="last_name" placeholder="Wprowadź nazwisko pracownika" required>
                    </div>
                    <div class="form-group">
                        <label for="date_of_birth">Data Urodzenia:</label>
                        <input type="date" name="date_of_birth" id="date_of_birth" required>
                    </div>
                    <div class="form-group-inline">
                        <label for="phone_number">Numer telefonu:</label>
                        <div class="phonenumber">
                            <?php
                                include('../DB/db_country_codes.php');
                                $baza = new db_country_codes();
                                $baza->databaseConnect();
                                $data = $baza->selectCountryCodes();
                                if ($data) {
                                    echo '<select name="id_country_code" class="kierunkowy">';
                                    while ($row = mysqli_fetch_assoc($data)) {
                                        echo "<option value='{$row['id_country_code']}'>{$row['country_code']} {$row['country']}</option>";
                                    }
                                    echo '</select>';
                                }
                                $baza->close();
                            ?>
                            <input type="tel" name="phone_number" placeholder="Numer telefonu pracownika" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email_address">Adres e-mail:</label>
                        <input type="email" name="email_address" placeholder="imie.nazwisko@secur-it.pl" required>
                    </div>
                    <div class="form-group">
                        <label for="photo">Zdjęcie:</label>
                        <input type="file" name="photo" id="photo" accept="image/*" required>
                    </div>
                    <div class="form-group">
                        <label for="PESEL">Numer PESEL:</label>
                        <input type="number" name="PESEL" placeholder="Wprowadź numer PESEL" required>
                    </div>
                    <div class="form-group">
                        <label for="home_address">Adres zamieszkania:</label>
                        <input type="text" name="home_address" placeholder="Wprowadź adres zamieszkania" required>
                    </div>
                    <div class="form-group">
                        <label for="id_position">Stanowisko:</label>
                        <select name="id_position" id="id_position" required>
                            <option value="" disabled selected>Wybierz stanowisko</option>
                            <?php
                                while ($row = mysqli_fetch_assoc($positions)) {
                                    echo "<option value='{$row['id_position']}'>{$row['name']}</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="id_department">Dział:</label>
                        <select name="id_department" id="id_department" required>
                            <option value="" disabled selected>Wybierz dział</option>
                            <?php
                                while ($row = mysqli_fetch_assoc($departments)) {
                                    echo "<option value='{$row['id_department']}'>{$row['department_name']}</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="id_work_location">Lokalizacja pracy:</label>
                        <select name="id_work_location" id="id_work_location" required>
                            <option value="" disabled selected>Wybierz lokalizację pracy</option>
                            <?php
                                while ($row = mysqli_fetch_assoc($work_locations)) {
                                    echo "<option value='{$row['id_location']}'>{$row['street']} {$row['building_number']}, {$row['city']}, {$row['country']}</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="contract_number">Numer umowy:</label>
                        <input type="text" name="contract_number" placeholder="Wprowadź numer umowy" required>
                    </div>
                    <div class="form-group">
                        <label for="id_contract_type">Typ umowy:</label>
                        <select name="id_contract_type" id="id_contract_type" required>
                            <option value="" disabled selected>Wybierz typ umowy</option>
                            <?php
                                while ($row = mysqli_fetch_assoc($contract_types)) {
                                    echo "<option value='{$row['id_contract_type']}'>{$row['contract_type']}</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="insurance_number">Numer ubezpieczenia:</label>
                        <input type="text" name="insurance_number" placeholder="Wprowadź numer ubezpieczenia" required>
                    </div>
                    <div class="form-group">
                        <label for="start_date">Data rozpoczęcia pracy:</label>
                        <input type="date" name="start_date" required>
                    </div>
                    <div class="form-group">
                        <label for="end_date">Data zakończenia pracy:</label>
                        <input type="date" name="end_date">
                    </div>
                    <div class="form-group">
                        <label for="salary">Wynagrodzenie:</label>
                        <input type="number" name="salary" placeholder="Wprowadź wartość wynagrodzenia" required>
                    </div>
                    <div class="form-group">
                        <label for="bonus">Premia:</label>
                        <input type="number" name="bonus" placeholder="Wprowadź wartość premii">
                    </div>
                    <div class="form-group">
                        <label for="id_car">Auto:</label>
                        <select name="id_car" id="id_car">
                            <option value="" disabled selected>Wybierz auto</option>
                            <?php
                                while ($row = mysqli_fetch_assoc($cars)) {
                                    echo "<option value='{$row['id_car']}'>{$row['brand']} {$row['model']}, {$row['production_year']}, {$row['color']}</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="username">Nazwa użytkownika:</label>
                        <input type="text" name="username" placeholder="Wprowadź nazwę użytkownika" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Hasło:</label>
                        <input type="password" name="password" placeholder="Wprowadź hasło" required>
                    </div>
                    <div class="button-group">
                        <button type="submit" class="modern-button">Dodaj Pracownika</button>
                    </div>
                </form>
            </section>
        </main>
    </body>
</html>