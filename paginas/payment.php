<?php
    // Inicia as SESSIONS
    session_start();

    // Obtêm as functions e as variaveis do ficheiro
    include_once '../basedados/basedados.h';

    // Conecta a base de dados
    $conn = connect_db();

    // Verifica se um utilizador esta autenticado
    if (!isset($_SESSION['email'])) {
        header("Location: ./signin.php");
        exit();
    }

    // Guarda os dados vindos do Front-End
    $orderName = $_POST['order-name'];
    $destiny = $_POST['destiny'];
    $money = $_POST['money'];
    $totalPrice = $_POST['total-price'];

    // Verifica se os dados são diferente de null e undefined
    if(!isset($destiny) || !isset($orderName) || !isset($money) || !isset($totalPrice)) {
        header("Location: ./cart.php");
        exit();
    }

    // Verifica se o dinheiro do utilizador e o total apagar são menores que 0 e se o total é maior que o dinheiro do utilizador
    if($money < 0 || $totalPrice < 0 || $totalPrice > $money) {
        header("Location: ./cart.php?error=It seems that you dont have enougth money...");
        exit();
    }

    // Tenta executar a query, caso contrário redireciona de volta a pagina shop
    try {
        // Obtêm todas as orders do utilizador
        $orders = run_select($conn, 'CALL get_user_orders(?)', 's', [$_SESSION['email']]);

        // Verifica se já existe uma order com aquele nome
        foreach($orders as $order) {
            if($order['order_name'] === $orderName) {
                header("Location: ./cart.php?error=You already have an order with that name!");
                exit();
            }
        }

        run_modify($conn, 'CALL ongoing_order(?, ?, ?)', 'sss', [
            $_SESSION['email'],
            $orderName,
            $destiny
        ]);

        close_db($conn);
    } catch(Exception $e) {
        header("Location: ./shop.php");
        exit();
    }

    header("Location: ./shop.php");
    exit();
?>