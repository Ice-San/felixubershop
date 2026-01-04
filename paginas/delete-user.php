<?php
    // Inicia as SESSIONS
    session_start();

    // Verifica se um utilizador esta autenticado
    if (!isset($_SESSION['email'])) {
        header("Location: ./signin.php");
        exit();
    }

    // Obtêm as functions e as variaveis do ficheiro
    include_once '../basedados/basedados.h';

    // Connecta a base de dados
    $conn = connect_db();

    // Guarda os dados do Front-End
    $email = $_POST['email'];

    // Verifica se os dados são diferente de null ou undefined
    if(!isset($email)) {
        header("Location: ./users.php");
        exit();
    }

    // Tenta executar a query
    // Caso contrário retorna a pagina de users
    try {
        run_modify($conn, 'CALL delete_user(?)', 's', [$email]);
        close_db($conn);
    } catch(Exception $e) {
        header("Location: ./users.php");
        exit();
    }

    header("Location: ./users.php");
    exit();
?>