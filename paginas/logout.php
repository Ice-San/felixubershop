<?php
    // Inicia as SESSIONS
    session_start();
    // Apaga todas as SESSION
    session_destroy();

    // Obtêm o URL da Pagina anterior
    $url = isset($_POST['previous_url']) ? $_POST['previous_url'] : './shop.php';

    // Redireciona a pagina anterior
    header("Location: " . $url);
    exit();
?>