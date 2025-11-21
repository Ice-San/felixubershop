<?php
    include_once '../basedados/basedados.h';

    $conn = connect_db();
    
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if(empty($username) || empty($email) || empty($password)) {
        header("Location: ./signup.php");
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_ARGON2ID);

    $data = run_modify($conn, 'CALL create_user(?, ?, ?);', 'sss', [$username, $email, $hashed_password]);

    if (isset($data['error'])) {
        header("Location: ./signup.php");
        exit;
    }

    header("Location: ./signin.php");
    exit;
?>