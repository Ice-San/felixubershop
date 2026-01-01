<?php
    session_start();

    include_once '../basedados/basedados.h';

    $conn = connect_db();

    if (!isset($_SESSION['email'])) {
        header("Location: ./signin.php");
        exit();
    }

    $email = $_POST['email'];
    $orderName = $_POST['order-name'];
    $newOrderName = $_POST['new-order-name'];
    $newArrivalTime = $_POST['order-arrival'];

    if(!isset($email) || !isset($orderName) || !isset($newOrderName) || !isset($newArrivalTime)) {
        header("Location: ./orders.php");
        exit();
    }

    try {
        run_modify($conn, 'CALL update_order(?, ?, ?, ?, ?)', 'sssss', [
            $email,
            $orderName,
            'ongoing',
            $newOrderName,
            $newArrivalTime,
        ]);
        close_db($conn);

        header("Location: ./orders.php");
        exit();
    } catch(Exception $e) {
        header("Location: ./orders.php");
        exit();
    }
?>