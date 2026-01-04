<?php
    // Inicia as SESSIONS
    session_start();

    // Obtêm as funções e variaveis do ficheiro
    include_once '../basedados/basedados.h';

    // Verifica se um utilizador esta autenticado
    if (!isset($_SESSION['email'])) {
        header("Location: ./signin.php");
        exit();
    }

    // Obtêm os dados do Front-End
    $email = $_POST['email'];

    // Verifica se os dados são diferente de null ou undefined
    if(!isset($email)) {
        header("Location: ./signin.php");
        exit();
    }

    // Tenta executar a query, caso contrário redireciona de volta a pagina users ou profile
    try {
        $conn = connect_db();
        $data = run_modify($conn, 'CALL delete_user_money(?);', 's', [$email]);
        close_db($conn);
    } catch(Exception $e) {
        if($email != $_SESSION['email']) {
            header("Location: ./users.php");
            exit();
        }

        header("Location: ./profile.php");
        exit;
    }

    if($email != $_SESSION['email']) {
        header("Location: ./users.php");
        exit();
    }

    header("Location: ./profile.php");
    exit;
?>