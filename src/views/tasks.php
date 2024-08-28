<?php
    session_start();
    include "../database/db_connection.php";

    // Verificar si el usuario ha iniciado sesión
    if (!isset($_SESSION['id_users'])) {
        header("Location: login.php");
        exit();
    }

    $id_users = $_SESSION['id_users'];

    // Agregar una nueva tarea
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'] ) ){

        $name_task = $_POST['name'];
        $description_task = $_POST['description'];
        $status_task = $_POST['status'];

        if ($conexion) {
            // Inserta la nueva tarea en la base de datos
            $stmt = $conexion->prepare("INSERT INTO tasks (	id_users, name, description, status	) VALUES (?, ?, ?,?)");
            $stmt->bind_param("ssss", $id_users, $name_task, $description_task, $status_task );

            if ($stmt->execute()) {
                echo "Nueva tarea agregada con éxito.";
            } else {
                echo "Error al agregar la tarea: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error de conexión a la base de datos.";
        }
    }

    // Mostrar todas las tareas del usuario actual
    if ($conexion) {
        $stmt = $conexion->prepare("SELECT name, description, status, id_tasks FROM tasks WHERE id_users = ?");
        $stmt->bind_param("i", $id_users);
        $stmt->execute();
        $result = $stmt->get_result();

        $tasks = [];
        while ($row = $result->fetch_assoc()) {
            $tasks[] = $row;
        }

        $stmt->close();
    } else {
        echo "Error de conexión a la base de datos.";
    }

    $conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Tareas</title>
</head>
<body>
    <h1>Bienvenido, <?php echo $_SESSION['name_user']; ?>!</h1>
    <h2>Tus Tareas</h2>
    <hr/>

    <!-- Mostrar lista de tareas -->
    <ul>
        <?php if (!empty($tasks)): ?>
            <?php foreach ($tasks as $task): ?>
                <li>
                    <?php echo htmlspecialchars($task['name']); ?> - 
                    <?php echo htmlspecialchars($task['description']); ?> 
                    - <em> <?php echo htmlspecialchars($task['status']); ?> </em>
                    <a href="task-description.php?id=<?php echo $task['id_tasks']; ?>">Editar</a>            </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>No tienes tareas por el momento.</li>
        <?php endif; ?>
    </ul>

    <!-- Formulario para agregar nuevas tareas -->
    <h2>Agregar Nueva Tarea</h2>
    <hr/>

    <form method="POST">
        <input type="text" name="name" placeholder="Nombre de tarea" required><br>
        <br>
        <input type="text" name="description" placeholder="Descripcion" required><br>
        <br>
        <select class="custom-select" id="status" name="status">
            <option value="Pendiente">Pendiente</option>
            <option value="En Curso">En Curso</option>
            <option value="Finalizado">Finalizado</option>
        </select>

        <br>
        <br>

        <button type="submit">Agregar Tarea</button>
    </form>
</body>
</html>