<?php
    // Inicia as SESSIONS
    session_start();

    // Obtêm as funções e variaveis dos ficheiros
    include_once '../basedados/basedados.h';

    // Conecta a base de dados
    $conn = connect_db();

    // Verifica se o utilizador esta autenticado
    if (!isset($_SESSION['email'])) {
        header("Location: ./signin.php");
        exit();
    }

    // Guarda os dados vindos do Front-End
    $productName = $_POST['product-name'];
    $orderName = $_POST['order-name'];
    $email = $_POST['email'];
    $orderStatus = $_POST['order-status'];

    // Verifica se os dados são diferentes de null ou undefined
    if (!isset($email) || !isset($orderStatus) || !isset($orderName)) {
        header('Location: ./orders.php');
        exit();
    }

    // Verifica se os dados são diferentes de null ou undefined
    if(!isset($productName) || !isset($orderName)) {
        header("Location: ./cart.php");
        exit();
    }

    // Tenta executar as querys, caso contrário redireciona para as paginas de orders ou cart
    try {
        if($orderName === "order1") {
            run_modify($conn, 'CALL remove_product_quantity(?, ?, ?, ?)', 'ssss', [
                $_SESSION['email'],
                $productName,
                $orderName,
                "pending",
            ]);
        }

        if($orderName !== "order1") {
            run_modify($conn, 'CALL remove_product_quantity(?, ?, ?, ?)', 'ssss', [
                $email,
                $productName,
                $orderName,
                $orderStatus,
            ]);
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

    close_db($conn);

    if($orderStatus === "ongoing") {
        header('Location: ./orders.php');
        exit();
    }

    if($orderStatus === "pending") {
        header('Location: ./cart.php');
        exit();
    }

    header('Location: ./shop.php');
    exit();
?>