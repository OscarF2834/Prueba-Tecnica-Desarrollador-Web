<?php
//Incluir archivo de la base de datos
include 'db.php';

// Condicional para crear tarea
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST["titulo"];
    $descripcion = $_POST["descripcion"];

    $sql = "INSERT INTO tareas (titulo, descripcion) VALUES ('$titulo', '$descripcion')";
    echo ($conn->query($sql) ? "Tarea creada" : "Error: " . $conn->error);
}

// Condicional para obtener tareas
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $result = $conn->query("SELECT * FROM tareas");
    $tareas = [];
    while ($row = $result->fetch_assoc()) {
        $tareas[] = $row;
    }
    echo json_encode($tareas);
}

// Condicional para actualizar tarea
if ($_SERVER["REQUEST_METHOD"] == "PUT") {
    parse_str(file_get_contents("php://input"), $_PUT);
    $id = $_PUT["id"];
    $titulo = $_PUT["titulo"];
    $descripcion = $_PUT["descripcion"];

    $sql = "UPDATE tareas SET titulo='$titulo', descripcion='$descripcion' WHERE id=$id";
    echo ($conn->query($sql) ? "Tarea actualizada" : "Error: " . $conn->error);
}

// Condicional para eliminar tarea
if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    parse_str(file_get_contents("php://input"), $_DELETE);
    $id = $_DELETE["id"];

    $sql = "DELETE FROM tareas WHERE id=$id";
    echo ($conn->query($sql) ? "Tarea eliminada" : "Error: " . $conn->error);
}
?>
