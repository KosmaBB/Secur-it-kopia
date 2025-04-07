<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    if(!isset($_SESSION['sesja'])){
        session_start();
        $_SESSION['sesja'] = "test";
    }
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        $id_user = $_SESSION['id_user'];
        $is_admin = $_SESSION['is_admin'];
        $id_employee = $_SESSION['id_employee'];
        $id_company = $_SESSION['id_company'];
    }
    else {
        $id_company = 0;
        $id_employee = 0;
        $id_user = 0;
        $is_admin  = 0;
    }
?>