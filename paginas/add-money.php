<?php
    // Inicia as Sessions
    session_start();

    // Busca todas as funções e variaveis do ficheiro.
    include_once '../basedados/basedados.h';

    // Verifica se o utilizador esta autenticado
    if (!isset($_SESSION['email'])) {
        header("Location: ./signin.php");
        exit();
    }

    // Guarda os valores vindos do Front-End
    $email = $_POST['email'];
    $money = $_POST['money'];

    // Verifica se o email é diferente de null e undefined
    if(!isset($email)) {
        header("Location: ./signin.php");
        exit();
    }

    // Verifica se o money é diferente de null e undefined
    if(!isset($money)) {
        header("Location: ./profile.php?error=Some required fields are missing!");
        exit();
    }

    // Verifica se o money é maior ou igual a zero
    if($money <= 0) {
        header("Location: ./profile.php?error=Product price must be bigger than 0!");
        exit();
    }

    // Verifica se o tipo da varivavel é do tipo float 
    if(filter_var($money, FILTER_VALIDATE_FLOAT) === false) {
        header("Location: ./profile.php?error=Product price or stock must be an valid number!");
        exit();
    }

    // Tenta executar a query, em caso de falha retorna a pagina de profile
    try {
        // Conecta, executa o UPDATE e fecha a conecção.
        $conn = connect_db();
        run_modify($conn, 'CALL update_user_money(?, ?);', 'ss', [$email, $money]);
        close_db($conn);
    } catch(Exception $e) {
        // Redireciona para a pagina de profile
        header("Location: ./profile.php");
        exit;
    }

    // Verifica se o email vindo do POST é diferente do guardado nas SESSIONS
    if($email != $_SESSION['email']) {
        header("Location: ./users.php");
        exit();
    }

    // Redireciona para a pagina de profile
    header("Location: ./profile.php");
    exit;
?>