<?php

    function connect(string $host, string $database, string $username, string $password, int $port = 3308): PDO {
        try {
            $dsn = "mysql:host={$host};port={$port};dbname={$database}";

            $conn = new PDO($dsn, $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $conn;
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            echo 'Something went wrong!!!' . $error_message . '!';
        }
    }
