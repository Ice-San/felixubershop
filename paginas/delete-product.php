<?php
    session_start();

    if (!isset($_SESSION['email'])) {
        header("Location: ./signin.php");
        exit();
    }

    include_once '../basedados/basedados.h';
    $conn = connect_db();

    $productName = $_POST['product-name'];
    if(!isset($productName)) {
        header("Location: ./products.php");
        exit();
    }

    run_modify($conn, 'CALL delete_product(?)', 's', [$productName]);
    close_db($conn);

    header("Location: ./products.php");
    exit();
?>