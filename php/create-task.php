<?php
include 'db.php';

$title = $_POST['title'];
$description = $_POST['description'];

$sql = "INSERT INTO tasks (title, description) VALUES ('$title', '$description')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["status" => "success", "message" => "Tarea creada correctamente"]);
} else {
    echo json_encode(["status" => "error", "message" => "Error: " . $sql . "<br>" . $conn->error]);
}

$conn->close();
?>