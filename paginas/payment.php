<?php
    session_start();

    include_once '../basedados/basedados.h';

    $conn = connect_db();

    if (!isset($_SESSION['email'])) {
        header("Location: ./signin.php");
        exit();
    }

    $orderName = $_POST['order-name'];
    $destiny = $_POST['destiny'];
    $money = $_POST['money'];
    $totalPrice = $_POST['total-price'];

    if(!isset($destiny) || !isset($orderName) || !isset($money) || !isset($totalPrice)) {
        header("Location: ./cart.php");
        exit();
    }

    if($money < 0 || $totalPrice < 0 || $totalPrice > $money) {
        header("Location: ./cart.php?error=It seems that you dont have enougth money...");
        exit();
    }

    $orders = run_select($conn, 'CALL get_user_orders(?)', 's', [$_SESSION['email']]);

    foreach($orders as $order) {
        if($order['order_name'] === $orderName) {
            header("Location: ./cart.php?error=You already have an order with that name!");
            exit();
        }
    }

    run_modify($conn, 'CALL ongoing_order(?, ?, ?)', 'sss', [
        $_SESSION['email'],
        $orderName,
        $destiny
    ]);

    close_db($conn);

    header("Location: ./shop.php");
    exit();
?>