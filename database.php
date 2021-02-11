<?php
    $dsn = 'mysql:host=localhost;dbname=todolist';
    $username = 'root';
    $password = 'sesame';

    try {
        $db = new PDO($dsn, $username, $password);
        // $db = new PDO($dsn, $username);      // without password
    } catch (PDOException $e) {
        $error_message = 'Database Error: ';
        $error_message .= $e->getMessage();
        echo $error_message;
        exit();
    }
?>