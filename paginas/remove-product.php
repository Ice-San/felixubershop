<?php
    session_start();

    include_once '../basedados/basedados.h';

    $conn = connect_db();

    if (!isset($_SESSION['email'])) {
        header("Location: ./signin.php");
        exit();
    }

    $productName = $_POST['product-name'];
    $orderName = $_POST['order-name'];

    if(!isset($productName) || !isset($orderName)) {
        header("Location: ./cart.php");
        exit();
    }

    run_modify($conn, 'CALL remove_product(?, ?, ?, ?)', 'ssss', [
        $_SESSION['email'],
        $productName,
        $orderName,
        "pending",
    ]);

    close_db($conn);

    header("Location: ./cart.php");
    exit();
?>