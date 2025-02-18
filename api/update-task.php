<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../models/Task.php';

$task = new Task();

// Obtener datos enviados
$data = json_decode(file_get_contents("php://input"));

if(!empty($data->id) && !empty($data->title)) {
    $task->id = $data->id;
    $task->title = $data->title;
    $task->description = $data->description ?? "";
    
    if($task->update()) {
        http_response_code(200);
        echo json_encode(array("message" => "Tarea actualizada correctamente."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "No se pudo actualizar la tarea."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "No se puede actualizar la tarea. Los datos están incompletos."));
}
?>