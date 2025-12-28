<?php
    session_start();

    include_once '../basedados/basedados.h';

    $conn = connect_db();

    if (!isset($_SESSION['email'])) {
        header("Location: ./signin.php");
        exit();
    }

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $address = $_POST['address'];

    if ($password !== '****') {
        $hashed_password = password_hash($password, PASSWORD_ARGON2ID);
    } else {
        $hashed_password = '';
    }

    run_modify($conn, 'CALL update_user(?, ?, ?, ?)', 'ssss', [
        $username,
        $email,
        $hashed_password,
        $address,
    ]);
    close_db($conn);

    if($email != $_SESSION['email']) {
        header("Location: ./users.php");
        exit();
    }

    header("Location: ./profile.php");
    exit();
?>