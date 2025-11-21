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

    if (isset($data['error'])) {
        header("Location: ./signin.php");
        exit;
    }

    if(count($data) === 0) {
        $_SESSION['errorEmail'] = 'There is no user with that email...';
        header("Location: ./signin.php");
        exit;
    }

    if(!password_verify($password, $data[0]['hashed_password'])) {
        $_SESSION['errorPassword'] = 'Passwords doesn\'t matches!';
        header("Location: ./signin.php");
        exit;
    }

    $_SESSION['email'] = $email;
    close_db($conn);

    header("Location: ./shop.php");
    exit;
?>