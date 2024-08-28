<?php
require 'includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO usuarios ( email, password) VALUES (:email, :password)";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute(['nombre' => $nombre, 'email' => $email, 'password' => $password]);
        echo "Registro exitoso";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>