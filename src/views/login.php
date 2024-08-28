<?php

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
</head>
<body>
    <h2>Iniciar Sesión</h2>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required><br>
        <br>
        <input type="password" name="password" placeholder="Contraseña" required><br>
        <br>
        <button type="submit">Iniciar Sesión</button>
        <br>
        <br>
        Si no tienes cuenta puedes crear una <a href='/Login/src/views/register.php'>aqui</a>
    </form>
</body>
</html>