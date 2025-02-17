<?php
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "tasks_db";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>