<?php
    // Inicia as SESSIONS
    session_start();

    // Busca as functions e as variaveis no ficheiro
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

    // Verifica se os dados são diferentes de null ou undefined
    if (!isset($_POST['product-name'])) {
        header('Location: ./shop.php');
        exit();
    }

    // Tenta executar a query, em caso de falha retorna a pagina de shop
    try {
        run_modify($conn, 'CALL add_product(?, ?, ?, ?)', 'ssss', [$productName, $_SESSION['email'], '', 'pending']);
        close_db($conn);
    } catch(Exception $e) {
        header('Location: ./shop.php');
        exit();
    }

    header('Location: ./shop.php');
    exit();
?>