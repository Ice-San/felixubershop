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
    $email = $_POST['email'];
    $orderStatus = $_POST['order-status'];

    if (!isset($email) || !isset($orderStatus) || !isset($orderName)) {
        header('Location: ./orders.php');
        exit();
    }

    if(!isset($productName) || !isset($orderName)) {
        header("Location: ./cart.php");
        exit();
    }

    try {
        if($orderName === "order1") {
            run_modify($conn, 'CALL remove_product(?, ?, ?, ?)', 'ssss', [
                $_SESSION['email'],
                $productName,
                $orderName,
                "pending",
            ]);
        }

        if($orderName !== "order1") {
            run_modify($conn, 'CALL remove_product(?, ?, ?, ?)', 'ssss', [
                $email,
                $productName,
                $orderName,
                $orderStatus,
            ]);
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

    close_db($conn);

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