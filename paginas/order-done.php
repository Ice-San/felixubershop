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


    if(!isset($orderName) || !isset($ownerEmail)) {
        header("Location: ./orders.php");
        exit();
    }

    run_modify($conn, 'CALL done_order(?, ?)', 'ss', [
        $ownerEmail,
        $orderName
    ]);
    close_db($conn);

    header("Location: ./orders.php");
    exit();
?>