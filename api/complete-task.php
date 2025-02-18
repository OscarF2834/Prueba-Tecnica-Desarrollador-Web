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

if(!empty($data->id)) {
    $task->id = $data->id;
    
    if($task->complete()) {
        http_response_code(200);
        echo json_encode(array("message" => "Tarea marcada como completada correctamente."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "No se pudo marcar la tarea como completada."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "No se puede marcar la tarea como completada. Proporcione un ID."));
}
?>