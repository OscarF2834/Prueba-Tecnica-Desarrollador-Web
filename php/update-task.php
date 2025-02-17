<?php
include 'db.php';

$id = $_POST['id'];
$title = $_POST['title'];
$description = $_POST['description'];

$sql = "UPDATE tasks SET title='$title', description='$description' WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["status" => "success", "message" => "Tarea actualizada correctamente"]);
} else {
    echo json_encode(["status" => "error", "message" => "Error: " . $sql . "<br>" . $conn->error]);
}

$conn->close();
?>