<?php
    session_start();

    if (!isset($_SESSION['email'])) {
        header("Location: ./signin.php");
        exit();
    }

    include_once '../basedados/basedados.h';
    $conn = connect_db();

    $email = $_POST['email'];
    if(!isset($email)) {
        header("Location: ./users.php");
        exit();
    }

    run_modify($conn, 'CALL delete_user(?)', 's', [$email]);
    close_db($conn);

    header("Location: ./users.php");
    exit();
?>