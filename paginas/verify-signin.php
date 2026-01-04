<?php
    // Inicia as SESSIONS
    session_start();

    // Obtêm as funções e variaveis da base de dados
    include_once '../basedados/basedados.h';

    // Conecta a base de dados
    $conn = connect_db();

    // Guarda os dados vindos do Front-End
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Verifica se o email e password estão vazios
    if(empty($email) || empty($password)) {
        header("Location: ./signin.php");
        exit;
    }

    // Tenta executar a query, caso contrário redireciona de volta a pagina signin
    try {
        // Obtêm se o utilizador é valido ou não
        $data = run_select($conn, 'CALL sign_in(?);', 's', [$email]);
    } catch(Exception $e) {
        header("Location: ./signin.php");
        exit;
    }

    // Verifica se ocorreu algum erro
    if (isset($data['error'])) {
        header("Location: ./signin.php");
        exit;
    }

    // Verifica se o utilizador existe
    if(count($data) === 0) {
        $_SESSION['errorEmail'] = 'There is no user with that email...';
        header("Location: ./signin.php");
        exit;
    }

    // Verifica se as passwords coincidem
    if(!password_verify($password, $data[0]['hashed_password'])) {
        $_SESSION['errorPassword'] = 'Passwords doesn\'t matches!';
        header("Location: ./signin.php");
        exit;
    }

    // Loga o utilizador na base de dados!
    $_SESSION['email'] = $email;
    close_db($conn);

    header("Location: ./shop.php");
    exit;
?>