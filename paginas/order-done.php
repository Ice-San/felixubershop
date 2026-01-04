<?php
    // Inicia as SESSIONS
    session_start();

    // Verifica se um utilizador esta autenticado
    if (!isset($_SESSION['email'])) {
        header("Location: ./signin.php");
        exit();
    }

    // Obtêm as functions e variaveis do ficheiro
    include_once '../basedados/basedados.h';

    // Conecta a base de dados
    $conn = connect_db();

    // Guarda os dados vindos do Front-End
    $orderName = $_POST['order-name'];
    $ownerEmail = $_POST['owner-email'];

    // Verifica se os dados são diferente de null ou undefined
    if(!isset($orderName) || !isset($ownerEmail)) {
        header("Location: ./orders.php");
        exit();
    }

    // Tenta executar a query, caso contrário redireciona de volta a pagina orders
    try {
        run_modify($conn, 'CALL done_order(?, ?)', 'ss', [
            $ownerEmail,
            $orderName
        ]);
        close_db($conn);
    } catch(Exception $e) {
        header("Location: ./orders.php");
        exit();
    }

    header("Location: ./orders.php");
    exit();
?>