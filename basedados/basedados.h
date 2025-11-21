<?php
    function connect_db() {
        $host = "localhost";
        $user = "root";
        $password = "root";
        $db = "felixubershop_db";

        $conn = mysqli_connect($host, $user, $password, $db);
        
        if (!$conn) {
            die("Something went wrong when trying to connect to DB: " . mysqli_connect_error());
        }

        return $conn;
    }

    function close_db($conn) {
        mysqli_close($conn);
    }

    function sanitize($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        return $data;
    }

    function sanitize_params($params) {
        foreach ($params as $i => $p) {
            if (is_string($p)) {
                $params[$i] = sanitize($p);
            }
        }
        return $params;
    }

    function run_select($conn, $query, $types = "", $params = []) {
        $params = sanitize_params($params);
        $stmt = mysqli_prepare($conn, $query);

        if (!$stmt) {
            return ["error" => mysqli_error($conn)];
        }

        if (!empty($params)) {
            if (!mysqli_stmt_bind_param($stmt, $types, ...$params)) {
                return ["error" => mysqli_stmt_error($stmt)];
            }
        }

        if (!mysqli_stmt_execute($stmt)) {
            return ["error" => mysqli_stmt_error($stmt)];
        }

        $result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);

        while (mysqli_more_results($conn)) {
            mysqli_next_result($conn);
        }

        return $result ? mysqli_fetch_all($result, MYSQLI_ASSOC) : [];
    }

    function run_modify($conn, $query, $types = "", $params = []) {
        $params = sanitize_params($params);
        $stmt = mysqli_prepare($conn, $query);

        if (!$stmt) {
            return ["error" => mysqli_error($conn)];
        }

        if (!empty($params)) {
            if (!mysqli_stmt_bind_param($stmt, $types, ...$params)) {
                return ["error" => mysqli_stmt_error($stmt)];
            }
        }

        if (!mysqli_stmt_execute($stmt)) {
            return ["error" => mysqli_stmt_error($stmt)];
        }

        mysqli_stmt_close($stmt);

        while (mysqli_more_results($conn)) {
            mysqli_next_result($conn);
        }

        return true;
    }
?>