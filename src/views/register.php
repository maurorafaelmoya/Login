<?php
    include "../database/db_connection.php";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        if ($conexion) {
            $stmt = $conexion->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $password);

            if ($stmt->execute()) {
                echo "Usuario registrado con éxito.";
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error de conexión a la base de datos.";
        }

        $conexion->close();
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Crear Cuenta</title>
</head>
<body>
    <div>
        <h1>Crear Cuenta</h1>
        <hr>
        <form method="POST">
            <input type="text" name="name" placeholder="Nombre" required>
            <br>
            <br>
            <input type="email" name="email" placeholder="Email" required>
            <br>
            <br>
            <input type="text" name="password" placeholder="Contraseña" required>
            <br>
            <br>
            <button type="submit">Crear Cuenta</button>
            <br>
            <br>
            si ya tienes cuenta puedes <a href="login.php">Iniciar sesion</a>

        </form>
    </div>
</body>
</html>