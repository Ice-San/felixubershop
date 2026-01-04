<?php
    // Inicia as Sessions
    session_start();

    // Verifica se o utilizador esta autenticado
    if (!isset($_SESSION['email'])) {
        header("Location: ./signin.php");
        exit();
    }

    // Obtêm as functions e as variaveis do ficheiro
    include_once '../basedados/basedados.h';

    // Conecta a base de dados
    $conn = connect_db();

    // Guarda os dados vindos do Front-End
    $productName = $_POST['name'];
    $productPrice = $_POST['price'];
    $productStock = $_POST['stock'];
    $productCategory = $_POST['category'];
    $productDiscount = $_POST['discount'];

    // Verifica se os dados são diferentes de null e undefined
    if(!isset($productName) || !isset($productPrice) || !isset($productStock) || !isset($productCategory) || !isset($productDiscount)) {
        header("Location: ./products.php?error=Some required fields are missing");
        exit();
    }

    // Verifica se o preço é menor ou igual a 0
    if($productPrice <= 0) {
        header("Location: ./products.php?error=Product price must be bigger than 0!");
        exit();
    }

    // Verifica o tipo dos dados
    if(filter_var($productPrice, FILTER_VALIDATE_FLOAT) === false || filter_var($productStock, FILTER_VALIDATE_INT) === false) {
        header("Location: ./products.php?error=Product price or stock must be an valid number!");
        exit();
    }

    // Verifica se o dado contêm algum dos seguintes valores
    $discountsAvailable = ['0', '25', '50', '75', '90'];
    if(!in_array($productDiscount, $discountsAvailable, true)) {
        header("Location: ./products.php?error=You didnt provide an valid value in discounts input!");
        exit();
    }

    // Tenta executar a query, caso contrário redireciona de volta a pagina products
    try {
        run_modify($conn, 'CALL update_product(?, ?, ?, ?, ?)', 'sssss', [
            mb_strtolower($productName, 'UTF-8'),
            $productPrice,
            $productStock,
            $productDiscount,
            $productCategory
        ]);
        close_db($conn);

        header("Location: ./products.php");
        exit();
    } catch(Exception $e) {
        header("Location: ./products.php");
        exit();
    }
?>