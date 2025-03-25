<?php

$host = "localhost";
$usuario = "root";
$contrasena = "";
$base_datos = "gestor_tareas";

$conexion = new mysqli($host, $usuario, $contrasena, $base_datos, 3307);

if ($conexion->connect_error) {
 die("Error de conexión: " . $conexion->connect_error);
}