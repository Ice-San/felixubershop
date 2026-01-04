<?php
    // Inicia as Sessions
    session_start();

    // Busca todas as funções e variaveis do ficheiro.
    include_once '../basedados/basedados.h';
    
    // Conecta a base de dados
    $conn = connect_db();

    // Verifica se o utilizador esta autenticado
    if (!isset($_SESSION['email'])) {
        header("Location: ./signin.php");
        exit();
    }

    // Guarda os valores vindos do Front-End
    $productName = $_POST['product-name'];
    $email = $_POST['email'];
    $orderName = $_POST['order-name'];
    $orderStatus = $_POST['order-status'];

    // Verifica se os dados são diferente de null e undefined
    if (!isset($email) || !isset($orderStatus) || !isset($orderName)) {
        header('Location: ./orders.php');
        exit();
    }
    
    // Verifica se o dado é diferente de null e undefined
    if (!isset($_POST['product-name'])) {
        header('Location: ./cart.php');
        exit();
    }

    // Tenta executar a query, em caso de falha retorna a pagina de orders ou cart
    try {
        if($orderName === "order1") {
            run_modify($conn, 'CALL add_product(?, ?, ?, ?)', 'ssss', [$productName, $email, '', $orderStatus]);
            close_db($conn);
        }

        if($orderName !== "order1") {
            run_modify($conn, 'CALL add_product(?, ?, ?, ?)', 'ssss', [$productName, $email, $orderName, $orderStatus]);
            close_db($conn);
        }
    } catch(Exception $e) {
        if($orderStatus === "ongoing") {
            header('Location: ./orders.php');
            exit();
        }

        if($orderStatus === "pending") {
            header('Location: ./cart.php');
            exit();
        }
    }

    // Redireciona a pagina de orders se a order tiver status ongoing
    if($orderStatus === "ongoing") {
        header('Location: ./orders.php');
        exit();
    }

    // Redireciona a pagina de orders se a order tiver status pending
    if($orderStatus === "pending") {
        header('Location: ./cart.php');
        exit();
    }

    // Redireciona para a pagina de shop
    header('Location: ./shop.php');
    exit();
?>