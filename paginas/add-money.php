<?php
    session_start();

    include_once '../basedados/basedados.h';

    if (!isset($_SESSION['email'])) {
        header("Location: ./signin.php");
        exit();
    }

    $email = $_POST['email'];
    $money = $_POST['money'];

    if(!isset($email)) {
        header("Location: ./signin.php");
        exit();
    }

    if(!isset($money)) {
        header("Location: ./profile.php?error=Some required fields are missing!");
        exit();
    }

    if($money <= 0) {
        header("Location: ./profile.php?error=Product price must be bigger than 0!");
        exit();
    }

    if(filter_var($money, FILTER_VALIDATE_FLOAT) === false) {
        header("Location: ./profile.php?error=Product price or stock must be an valid number!");
        exit();
    }

    $conn = connect_db();
    run_modify($conn, 'CALL update_user_money(?, ?);', 'ss', [$email, $money]);
    close_db($conn);

    if($email != $_SESSION['email']) {
        header("Location: ./users.php");
        exit();
    }

    header("Location: ./profile.php");
    exit;
?>