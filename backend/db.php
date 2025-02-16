<?php
$host = "localhost";
$user = "root";
$password = "1234"; // Asegúrate de que es la contraseña correcta
$dbname = "tareas_db";

$conexion = new mysqli($host, $user, $password, $dbname);

if ($conexion->connect_error) {
    die(json_encode(["error" => "Error de conexión: " . $conexion->connect_error]));
}

// Configurar el conjunto de caracteres para evitar problemas con acentos
$conexion->set_charset("utf8mb4");
?>
