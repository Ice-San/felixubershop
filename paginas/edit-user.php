<?php
    // Inicia as SESSIONS
    session_start();

    // Obtêm as functions e as variaveis do ficheiro
    include_once '../basedados/basedados.h';

    // Conecta a base de dados
    $conn = connect_db();

    // Verifica se o utilizador esta autenticado
    if (!isset($_SESSION['email'])) {
        header("Location: ./signin.php");
        exit();
    }

    // Guarda os dados vindos do Front-End
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $address = $_POST['address'];

    // Verifica se a password é diferente do valor padrão do formulário
    // Caso seja, ele encrypta a password
    if ($password !== '****') {
        $hashed_password = password_hash($password, PASSWORD_ARGON2ID);
    } else {
        $hashed_password = '';
    }

    // Tenta executar a query, caso contrário redireciona de volta a pagina profile
    try {
        run_modify($conn, 'CALL update_user(?, ?, ?, ?)', 'ssss', [
            $username,
            $email,
            $hashed_password,
            $address,
        ]);
        close_db($conn);
    } catch(Exception $e) {
        header("Location: ./profile.php");
        exit();
    }

    // Verifica se o email vindo do Front-End é diferente do que esta guardado nas SESSIONS
    if($email != $_SESSION['email']) {
        header("Location: ./users.php");
        exit();
    }

    header("Location: ./profile.php");
    exit();
?>