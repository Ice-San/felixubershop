<?php
    session_start();

    include_once '../basedados/basedados.h';

    if (!isset($_SESSION['email'])) {
        header("Location: ./signin.php");
        exit();
    }

    $email = $_POST['email'];

    if(!isset($email)) {
        header("Location: ./signin.php");
        exit();
    }

    $conn = connect_db();
    $data = run_modify($conn, 'CALL delete_user_money(?);', 's', [$email]);
    close_db($conn);

    if($email != $_SESSION['email']) {
        header("Location: ./users.php");
        exit();
    }

    header("Location: ./profile.php");
    exit;
?>