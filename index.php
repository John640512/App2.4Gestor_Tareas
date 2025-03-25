<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Tareas</title>
    <link rel="stylesheet" href="estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div class="container">
        <h1><i class="fas fa-tasks"></i> Gestor de Tareas</h1>

        <?php
        include "conexion.php";

        $sql = "SELECT * FROM tareas ORDER BY completada ASC, id DESC";
        $resultado = mysqli_query($conexion, $sql);

        if (mysqli_num_rows($resultado) > 0) {
            echo '<div class="task-list">';
            
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $statusClass = $fila['completada'] ? 'completed' : 'pending';
                $statusText = $fila['completada'] ? 'Completada' : 'Pendiente';
                
                echo "<div class='task'>";
                echo "<h2>" . htmlspecialchars($fila['titulo']) . "</h2>";
                echo "<span class='task-status $statusClass'><i class='fas " . ($fila['completada'] ? 'fa-check-circle' : 'fa-clock') . "'></i> $statusText</span>";
                echo "<p>" . htmlspecialchars($fila['descripcion']) . "</p>";
                echo "<div class='task-actions'>";
                
                if (!$fila['completada']) {
                    echo "<a href='marcar_como_completada.php?id={$fila['id']}' class='btn btn-success'><i class='fas fa-check'></i> Completar</a>";
                }
                
                echo "<a href='editar_tarea.php?id={$fila['id']}' class='btn btn-primary'><i class='fas fa-edit'></i> Editar</a>";
                echo "<a href='eliminar_tarea.php?id={$fila['id']}' class='btn btn-danger'><i class='fas fa-trash-alt'></i> Eliminar</a>";
                echo "</div>";
                echo "</div>";
            }
            
            echo '</div>';
        } else {
            echo '<div class="empty-state">';
            echo '<i class="fas fa-clipboard-list" style="font-size: 3rem; color: #ccc; margin-bottom: 15px;"></i>';
            echo '<p>No hay tareas registradas. ¡Crea tu primera tarea!</p>';
            echo '</div>';
        }

        mysqli_close($conexion);
        ?>

        <div class="add-task-container">
            <a href="crear_tarea.html" class="btn btn-outline"><i class="fas fa-plus"></i> Crear Nueva Tarea</a>
        </div>
    </div>
</body>
</html>