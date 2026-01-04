<?php
    // Função para conectar a base de dados
    function connect_db() {
        $host = "localhost";
        $user = "root";
        $password = "root";
        $db = "felixubershop_db";

        $conn = mysqli_connect($host, $user, $password, $db);
        
        // Verifica se a conecção foi realizada com sucesso, caso contrário apresenta erro.
        if (!$conn) {
            die("Something went wrong when trying to connect to DB: " . mysqli_connect_error());
        }

        return $conn;
    }

    // Função para fechar a conecção a base de dados.
    function close_db($conn) {
        mysqli_close($conn);
    }

    // Função para sanitizar os dados enviados pelo front-end a um endpoint.
    function sanitize($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        return $data;
    }

    // Função para fazer um percurso de sanitização de um array de dados a sanitizar
    function sanitize_params($params) {
        foreach ($params as $i => $p) {
            if (is_string($p)) {
                $params[$i] = sanitize($p);
            }
        }
        return $params;
    }

    // Função para executar um SELECT e apresentar os dados da query no Front-End.
    // $conn -> trata-se da conecção
    // $query -> trata-se da query a ser executada. Ex: "SELECT * FROM users WHERE email = ?"
    // $types -> trata-se dos typos de cada um dos dados a serem enviados. Ex: "ssss" 4 dados do tipo string
    // $params -> trata-se de um array de valores a serem colocados na query. Ex: ["Ruben", 21, "Rua das Flores"]
    function run_select($conn, $query, $types = "", $params = []) {
        // Sanitização dos dados enviados
        $params = sanitize_params($params);
        // Prepara a query para ser executada futuramente
        $stmt = mysqli_prepare($conn, $query);

        // Verifica se a $stmt é null ou undefined
        if (!$stmt) {
            return ["error" => mysqli_error($conn)];
        }

        // Verifica se o $params esta vazio
        if (!empty($params)) {
            // Substitui os ? dentro da query pelos respetivos $params definindo a cada $params o tipo respetivo em $types
            if (!mysqli_stmt_bind_param($stmt, $types, ...$params)) {
                // Se ocorrer um erro ele termina a função por aqui e demonstra um erro.
                return ["error" => mysqli_stmt_error($stmt)];
            }
        }

        // Executa agora o SELECT e verifica se a execução foi um sucesso em caso contrário demonstra um erro.
        if (!mysqli_stmt_execute($stmt)) {
            return ["error" => mysqli_stmt_error($stmt)];
        }

        // Vai buscar o resultado do SELECT executado.
        $result = mysqli_stmt_get_result($stmt);
        // Termina a conecção a base de dados.
        mysqli_stmt_close($stmt);

        // Faz um loop para verificar se existe mais dados de resultado para obter e guarda-os caso existam.
        while (mysqli_more_results($conn)) {
            mysqli_next_result($conn);
        }

        // Caso $result possua um valor ou seja diferente de undefined ele retorna o fetch de todos os dados do SELECT, caso contrário retorna um array vazio.
        return $result ? mysqli_fetch_all($result, MYSQLI_ASSOC) : [];
    }

    function run_modify($conn, $query, $types = "", $params = []) {
        // Sanitização dos dados enviados
        $params = sanitize_params($params);
        // Prepara a query para ser executada futuramente
        $stmt = mysqli_prepare($conn, $query);

        // Verifica se a $stmt é null ou undefined
        if (!$stmt) {
            return;
        }

        // Executa agora o INSERT, UPDATE ou DELETE e verifica se a execução foi um sucesso em caso contrário demonstra um erro.
        if (!empty($params)) {
            if (!mysqli_stmt_bind_param($stmt, $types, ...$params)) {
                mysqli_stmt_close($stmt);
                return;
            }
        }

        // Vai buscar o resultado do INSERT, UPDATE ou DELETE executado, caso contrário fecha a conecção a base de dados e termina a função por ali com um return vazio.
        if (!mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            return;
        }

        // Verifica quantas rows foram afetadas durante a execução do INSERT, UPDATE ou DELETE
        $affected_rows = mysqli_stmt_affected_rows($stmt);
        mysqli_stmt_close($stmt);
    }

    // Obtêm as iniciais do username de um utilizador
    function get_user_initials($conn, $query, $types = "", $params = []) {
        // Executa e obtêm os dados de um SELECT a base de dados.
        $user = run_select($conn, $query, $types, $params);
        // Obtêm o username do primeiro utilizador encontrado no SELECT.
        $username = $user[0]['username'];

        // Cria um array com base na string dentrod o $username e remove os espaços em branco
        $parts = explode(" ", $username);
        $initials = "";

        // Obtêm as primeiras letras das palavras guardadas do array e une elas numa palavra só.
        foreach ($parts as $p) {
            if ($p !== "") {
                $initials .= strtoupper($p[0]);
            }
        }

        // Retorna as inicias do username.
        return $initials;
    }
?>