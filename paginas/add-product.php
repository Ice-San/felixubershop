<?php
    session_start();

    include_once '../basedados/basedados.h';
    
    $conn = connect_db();

    if (!isset($_SESSION['email'])) {
        header("Location: ./signin.php");
        exit();
    }

    $productName = $_POST['product-name'];
    $email = $_POST['email'];
    $orderName = $_POST['order-name'];
    $orderStatus = $_POST['order-status'];

    if (!isset($email) || !isset($orderStatus) || !isset($orderName)) {
        header('Location: ./orders.php');
        exit();
    }
    
    if (!isset($_POST['product-name'])) {
        header('Location: ./cart.php');
        exit();
    }

    try {
        if($orderName === "order1") {
            run_modify($conn, 'CALL add_product(?, ?, ?, ?)', 'ssss', [$productName, $email, '', $orderStatus]);
            close_db($conn);
        }

        if($orderName !== "order1") {
            run_modify($conn, 'CALL add_product(?, ?, ?, ?)', 'ssss', [$productName, $email, $orderName, $orderStatus]);
            close_db($conn);
        }
    } catch(Exception $e) {
        if($orderStatus === "ongoing") {
            header('Location: ./orders.php');
            exit();
        }

        if($orderStatus === "pending") {
            header('Location: ./cart.php');
            exit();
        }
    }

    if($orderStatus === "ongoing") {
        header('Location: ./orders.php');
        exit();
    }

    if($orderStatus === "pending") {
        header('Location: ./cart.php');
        exit();
    }

    header('Location: ./shop.php');
    exit();
?>