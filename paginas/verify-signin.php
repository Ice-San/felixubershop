<?php
    session_start();

    include_once '../basedados/basedados.h';

    $conn = connect_db();

    $email = $_POST['email'];
    $password = $_POST['password'];

    if(empty($email) || empty($password)) {
        header("Location: ./signin.php");
        exit;
    }

    $data = run_select($conn, 'CALL sign_in(?);', 's', [$email]);

    if (isset($data['error']) || count($data) === 0) {
        header("Location: ./signin.php");
        exit;
    }

    if(!password_verify($password, $data[0]['hashed_password'])) {
        header("Location: ./signin.php");
        exit;
    }

    $_SESSION['email'] = $email;
    close_db($conn);

    header("Location: ./shop.php");
    exit;
?>