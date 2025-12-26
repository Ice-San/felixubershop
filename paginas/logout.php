<?php
    session_start();
    session_destroy();

    $url = isset($_POST['previous_url']) ? $_POST['previous_url'] : './shop.php';

    header("Location: " . $url);
    exit();
?>