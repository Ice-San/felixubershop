<?php
    // Inicia as Sessions
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
    $email = $_POST['email'];
    $orderName = $_POST['order-name'];
    $newOrderName = $_POST['new-order-name'];
    $newArrivalTime = $_POST['order-arrival'];

    // Verifica se os dados são diferentes de null ou undefined
    if(!isset($email) || !isset($orderName) || !isset($newOrderName) || !isset($newArrivalTime)) {
        header("Location: ./orders.php");
        exit();
    }

    // Tenta executar a query, caso contrário redireciona de volta a pagina orders
    try {
        run_modify($conn, 'CALL update_order(?, ?, ?, ?, ?)', 'sssss', [
            $email,
            $orderName,
            'ongoing',
            $newOrderName,
            $newArrivalTime,
        ]);
        close_db($conn);

        header("Location: ./orders.php");
        exit();
    } catch(Exception $e) {
        header("Location: ./orders.php");
        exit();
    }
?>