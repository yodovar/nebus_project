<?php
    $host = 'localhost';
    $dbname = 'Nebus';
    $username = 'root';
    $password = 'root';
    
    try {
        $pdo = new PDO("mysql:host=$host;port=3307;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Ошибка подключения к базе данных: " . $e->getMessage();
        exit;
    }
?>