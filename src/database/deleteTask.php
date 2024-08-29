<?php

    session_start();

    include "./db_connection.php";

    // Verificar si el usuario ha iniciado sesión
    if (!isset($_SESSION['id_users'])) {
        header("Location: login.php");
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $task_id = $_POST['task_id'];
        
        if ($conexion) {
            $stmt = $conexion->prepare("DELETE FROM tasks WHERE  id_tasks = ? ");
            $stmt->bind_param("i", $task_id);

            if ($stmt->execute()) {
                header("Location: ../views/tasks.php");
                exit();
            } else {
                echo "Error al actualizar la tarea.";
            }

            $stmt->close();
        } else {
            echo "Error de conexión a la base de datos.";
        }
    }
