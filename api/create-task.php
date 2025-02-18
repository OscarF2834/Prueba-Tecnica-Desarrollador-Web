<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../models/Task.php';

$task = new Task();

// Obtener datos enviados
$data = json_decode(file_get_contents("php://input"));

if(!empty($data->title)) {
    $task->title = $data->title;
    $task->description = $data->description ?? "";
    
    if($task->create()) {
        http_response_code(201);
        echo json_encode(array("message" => "Tarea creada correctamente."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "No se pudo crear la tarea."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "No se puede crear la tarea. Los datos están incompletos."));
}
?>