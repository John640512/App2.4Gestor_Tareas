<?php

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_tarea = intval($_GET['id']);

    include "conexion.php";

    $sql = "UPDATE tareas SET completada = true WHERE id = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_tarea);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php");
    } else {
        error_log("Error al marcar como completada: " . mysqli_error($conexion));
        echo "Hubo un problema al marcar la tarea como completada.";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conexion);
    exit();
} else {
    echo "Error: ID de tarea no válido.";
}