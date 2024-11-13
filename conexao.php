<?php

$host = 'localhost'; 
$dbname = 'tarefas';  
$username = 'root';   
$password = '';      


try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexão bem-sucedida!";
} catch (PDOException $e) {
    echo "Falha na conexão: " . $e->getMessage();
}
?>
