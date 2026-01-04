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

    // Conecta a base de dados
    $conn = connect_db();

    // Obtêm os dados do Front-End
    $productName = $_POST['product-name'];

    // Verifica se os dados são diferentes de null ou undefined
    if(!isset($productName)) {
        header("Location: ./products.php");
        exit();
    }

    // Tenta executar a query
    // Caso contrário retorna a pagina de products
    try {
        run_modify($conn, 'CALL delete_product(?)', 's', [$productName]);
        close_db($conn);
    } catch(Exception $e) {
        header("Location: ./products.php");
        exit();
    }

    header("Location: ./products.php");
    exit();
?>