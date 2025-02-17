<?php
include 'db.php';

$id = $_POST['id'];

$sql = "UPDATE tasks SET completed=1 WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["status" => "success", "message" => "Tarea completada correctamente"]);
} else {
    echo json_encode(["status" => "error", "message" => "Error: " . $sql . "<br>" . $conn->error]);
}

$conn->close();
?>