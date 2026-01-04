<?php
    // Inicia as sessions
    session_start();

    // Verifica se um utilizador esta autenticado
    if (!isset($_SESSION['email'])) {
        header("Location: ./signin.php");
        exit();
    }

    // Obtêm as functions e as variaveis do ficheiro
    include_once '../basedados/basedados.h';

    // Conecta a base de dados
    $conn = connect_db();

    // Guarda os dados vindos do Front-End
    $orderName = $_POST['order-name'];
    $ownerEmail = $_POST['owner-email'];
    $arrivalTime = $_POST['arrival-time'];
    $orderStatus = $_POST['order-status'];

    // Verifica se os dados são diferentes de null ou undefined
    if(!isset($orderName) || !isset($ownerEmail) || !isset($orderStatus) || !isset($arrivalTime)) {
        header("Location: ./orders.php");
        exit();
    }

    // Tenta executar a query
    // Caso contrário retorna a pagina de orders
    try {
        run_modify($conn, 'CALL delete_order(?, ?, ?, ?)', 'ssss', [
            $ownerEmail,
            $orderName,
            $arrivalTime,
            $orderStatus
        ]);
        close_db($conn);
    } catch(Exception $e) {
        header("Location: ./orders.php");
        exit();
    }

    header("Location: ./orders.php");
    exit();
?>