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
    $productDiscount = $_POST['discount'];

    if(!isset($productName) || !isset($productPrice) || !isset($productStock) || !isset($productCategory) || !isset($productDiscount)) {
        header("Location: ./products.php?error=Some required fields are missing");
        exit();
    }

    if($productPrice <= 0) {
        header("Location: ./products.php?error=Product price must be bigger than 0!");
        exit();
    }

    if(filter_var($productPrice, FILTER_VALIDATE_FLOAT) === false || filter_var($productStock, FILTER_VALIDATE_INT) === false) {
        header("Location: ./products.php?error=Product price or stock must be an valid number!");
        exit();
    }

    $discountsAvailable = ['0', '25', '50', '75', '90'];
    if(!in_array($productDiscount, $discountsAvailable, true)) {
        header("Location: ./products.php?error=You didnt provide an valid value in discounts input!");
        exit();
    }

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
?>