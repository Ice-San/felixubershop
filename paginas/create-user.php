<?php
    // Obtêm as functions e variaveis do ficheiro
    include_once '../basedados/basedados.h';

    // Conecta a base de dados
    $conn = connect_db();
    
    // Guarda os dados vindos do Front-End
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Verifica se os dados estão vazios
    if(empty($username) || empty($email) || empty($password)) {
        header("Location: ./signup.php");
        exit;
    }

    // Encripta a password
    $hashed_password = password_hash($password, PASSWORD_ARGON2ID);

    // Verifica se o role é vazio
    // Caso NÃO SEJA, ele cria um utilizador com permissões especiais
    if(empty($role)) {
        try {
            $data = run_modify($conn, 'CALL create_user(?, ?, ?);', 'sss', [$username, $email, $hashed_password]);

            if (isset($data['error'])) {
                header("Location: ./signup.php");
                exit;
            }
        } catch(Exception $e) {
            header("Location: ./signin.php");
            exit;
        }

        header("Location: ./signin.php");
        exit;
    } else {
        try {
            $data = run_modify($conn, 'CALL create_special_user(?, ?, ?, ?);', 'ssss', [$username, $email, $hashed_password, $role]);
        } catch(Exception $e) {
            header("Location: ./users.php");
            exit;
        }

        header("Location: ./users.php");
        exit;
    }
?>