<?php

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_tarea = intval($_GET['id']);

    include "conexion.php";

    $sql = "DELETE FROM tareas WHERE id = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_tarea);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php");
    } else {
        error_log("Error al eliminar la tarea: " . mysqli_error($conexion));
        echo "Hubo un problema al eliminar la tarea.";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conexion);
    exit();
} else {
    echo "Error: ID de tarea no válido.";
}