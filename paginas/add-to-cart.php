<?php
    session_start();

    include_once '../basedados/basedados.h';
    
    $conn = connect_db();

    if (!isset($_SESSION['email'])) {
        header("Location: ./signin.php");
        exit();
    }

    $productName = $_POST['product-name'];

    if (!isset($_POST['product-name'])) {
        header('Location: ./shop.php');
        exit();
    }

    run_modify($conn, 'CALL add_product(?, ?, ?, ?)', 'ssss', [$productName, $_SESSION['email'], '', 'pending']);
    close_db($conn);

    header('Location: ./shop.php');
    exit();
?>