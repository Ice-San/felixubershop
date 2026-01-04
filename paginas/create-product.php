<?php
    // Inicia as SESSIONS
    session_start();

    // Verifica se o utilizador esta autenticado
    if (!isset($_SESSION['email'])) {
        header("Location: ./signin.php");
        exit();
    }

    // Obtêm as functions e as varivaveis do ficheiro
    include_once '../basedados/basedados.h';

    // Conecta a base de dados
    $conn = connect_db();

    // Obtêm os dados vindos do Front-End
    $productName = $_POST['name'];
    $productPrice = $_POST['price'];
    $productStock = $_POST['stock'];
    $productCategory = $_POST['category'];

    // Verifica se os dados são diferente de null ou undefined
    if(!isset($productName) || !isset($productPrice) || !isset($productStock) || !isset($productCategory)) {
        header("Location: ./products.php");
        exit();
    }

    // Verifica o tipo das varivaveis
    if(!filter_var($productPrice, FILTER_VALIDATE_FLOAT) || !filter_var($productStock, FILTER_VALIDATE_INT)) {
        header("Location: ./products.php");
        exit();
    }

    // Verifica se o preço e o stock são menores que 0
    if($productPrice < 0 || $productStock < 0) {
        header("Location: ./products.php");
        exit();
    }

    // Tenta executar a query, em caso de falha retorna a pagina de shop
    try {
        run_modify($conn, 'CALL create_product(?, ?, ?, ?)', 'ssss', [
            mb_strtolower($productName, 'UTF-8'),
            $productPrice,
            $productStock,
            $productCategory
        ]);
    close_db($conn);
    } catch(Exception $e) {
        header("Location: ./products.php");
        exit();
    }

    header("Location: ./products.php");
    exit();
?>