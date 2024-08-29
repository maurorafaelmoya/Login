<?php
    session_start();

    include "../database/db_connection.php";

    // Verificar si el usuario ha iniciado sesión
    if (!isset($_SESSION['id_users'])) {
        header("Location: login.php");
        exit();
    }

    $id_users = $_SESSION['id_users'];
    $task_id = $_GET['id'];

    // Obtener la información de la tarea actual
    if ($conexion) {
        $stmt = $conexion->prepare("SELECT name, description, status FROM tasks WHERE id_tasks = ? AND id_users = ?");
        $stmt->bind_param("ii", $task_id, $id_users);
        $stmt->execute();
        $result = $stmt->get_result();


        if ($result->num_rows > 0) {
            $task = $result->fetch_assoc();

            $name = $task['name'];
            $description = $task['description'];
            $status = $task['status'];
        } else {
            echo "No se encontró la tarea.";
            exit();
        }

        $stmt->close();
    } else {
        echo "Error de conexión a la base de datos.";
    }

    // Actualizar la tarea
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $status = $_POST['status'];

        if ($conexion) {
            $stmt = $conexion->prepare("UPDATE tasks SET name=? ,description=?, status=? WHERE id_tasks = ? AND id_users = ?");
            $stmt->bind_param("sssii", $name, $description, $status, $task_id, $id_users);

            if ($stmt->execute()) {
                // Redirigir de nuevo al dashboard después de la actualización
                header("Location: tasks.php");
                exit();
            } else {
                echo "Error al actualizar la tarea.";
            }

            $stmt->close();
        } else {
            echo "Error de conexión a la base de datos.";
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Descripcion tareas Select</title>
</head>
<body>

    <div >
        <h1> Editar Tarea 
            <button><a href="tasks.php"> Atras </a></button>
        </h1>
        <hr>

        <form method="POST">
            <input type="text" name="name" placeholder="Nombre de tarea" value="<?php echo $name; ?>" required><br>
            <br>
            <input type="text" name="description" placeholder="Descripcion"  value="<?php echo $description; ?>" required><br>
            <br>
            <select class="custom-select" id="status" name="status" >
                <option value="Pendiente" <?php if ($status == "Pendiente") echo "selected"; ?>>Pendiente</option>
                <option value="En Curso" <?php if ($status == "En Curso") echo "selected"; ?>>En Curso</option>
                <option value="Finalizado" <?php if ($status == "Finalizado") echo "selected"; ?> >Finalizado</option>
            </select>

            <br>
            <br>

            <button type="submit"> Actualizar Tarea</button>
        </form>     
        <form method="POST" action="../database/deleteTask.php" >
            <input type="hidden" name="task_id" value="<?php echo $task_id; ?>">
            <button type="submit"> Eliminar Tarea</button>
        </form>     

    </div>



</body>
</html>