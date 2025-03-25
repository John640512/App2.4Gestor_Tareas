<?php

include "conexion.php";

$conexion->set_charset("utf8");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];

    $sql = "INSERT INTO tareas (titulo, descripcion, completada) VALUES (?, ?, false)";

    $stmt = mysqli_prepare($conexion, $sql);

    mysqli_stmt_bind_param($stmt, "ss", $titulo, $descripcion);

    if (mysqli_stmt_execute($stmt)) {
            echo "¡La tarea se ha creado correctamente!";
            header("Location: index.php");
            exit();
        } else {
            echo "Error al crear la tarea: " . mysqli_error($conexion);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conexion);

}