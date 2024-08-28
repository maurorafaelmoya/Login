<?php
// config.php
$host = 'localhost';
$db = 'php_proyect';
$user = 'moya'; 
$pass = '7&CPu/>J1Td0'; 


try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en la conexión: " . $e->getMessage());
}
