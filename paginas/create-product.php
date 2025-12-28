<?php
    session_start();

    if (!isset($_SESSION['email'])) {
        header("Location: ./signin.php");
        exit();
    }

    include_once '../basedados/basedados.h';
    $conn = connect_db();

    $productName = $_POST['name'];
    $productPrice = $_POST['price'];
    $productStock = $_POST['stock'];
    $productCategory = $_POST['category'];

    if(!isset($productName) || !isset($productPrice) || !isset($productStock) || !isset($productCategory)) {
        header("Location: ./products.php");
        exit();
    }

    if(!filter_var($productPrice, FILTER_VALIDATE_FLOAT) || !filter_var($productStock, FILTER_VALIDATE_INT)) {
        header("Location: ./products.php");
        exit();
    }

    if($productPrice < 0 || $productStock < 0) {
        header("Location: ./products.php");
        exit();
    }

    run_modify($conn, 'CALL create_product(?, ?, ?, ?)', 'ssss', [
        mb_strtolower($productName, 'UTF-8'),
        $productPrice,
        $productStock,
        $productCategory
    ]);
    close_db($conn);

    header("Location: ./products.php");
    exit();
?>