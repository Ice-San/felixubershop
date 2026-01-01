<?php
    session_start();

    if (!isset($_SESSION['email'])) {
        header("Location: ./signin.php");
        exit();
    }

    include_once '../basedados/basedados.h';
    $conn = connect_db();

    $orderName = $_POST['order-name'];
    $ownerEmail = $_POST['owner-email'];
    $arrivalTime = $_POST['arrival-time'];
    $orderStatus = $_POST['order-status'];


    if(!isset($orderName) || !isset($ownerEmail) || !isset($orderStatus) || !isset($arrivalTime)) {
        header("Location: ./orders.php");
        exit();
    }

    run_modify($conn, 'CALL delete_order(?, ?, ?, ?)', 'ssss', [
        $ownerEmail,
        $orderName,
        $arrivalTime,
        $orderStatus
    ]);
    close_db($conn);

    header("Location: ./orders.php");
    exit();
?>