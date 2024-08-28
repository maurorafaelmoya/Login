<?php
    include "../database/db_connection.php";

    session_start(); 

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];

        if ($conexion) {
            $stmt = $conexion->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $hashed_password = $row['password'];

                if (password_verify($password, $hashed_password)) {

                    $_SESSION['id_users'] = $row['id'];
                    $_SESSION['name_user'] = $row['name'];

                    header("Location: tasks.php");

                } else {
                    echo "Contraseña incorrecta.";
                }
            } else {
                echo "No se encontró una cuenta con ese email.";
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
    <title>Iniciar Sesión</title>
</head>
<body>
    <div>
        <h1>Iniciar Sesión</h1>
        <hr/>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required><br>
            <br>
            <input type="password" name="password" placeholder="Contraseña" required><br>
            <br>
            <button type="submit">Iniciar Sesión</button>
            <br>
            <br>
            Si no tienes cuenta puedes crear una <a href="register.php">aqui</a>
        </form>
    </div>
</body>
</html>