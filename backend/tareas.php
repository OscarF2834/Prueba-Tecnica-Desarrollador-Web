<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

include 'db.php'; // Conexión a la BD

$method = $_SERVER["REQUEST_METHOD"];

if ($method == "GET") {
    $result = $conexion->query("SELECT * FROM tareas");
    $tareas = [];
    while ($row = $result->fetch_assoc()) {
        $tareas[] = $row;
    }
    echo json_encode($tareas);
}

if ($method == "POST") {
    error_log("Solicitud POST recibida"); // Mensaje para depuración

    if (!isset($_POST["titulo"]) || !isset($_POST["descripcion"])) {
        echo json_encode(["error" => "Título y descripción requeridos"]);
        exit;
    }

    $titulo = $conexion->real_escape_string($_POST["titulo"]);
    $descripcion = $conexion->real_escape_string($_POST["descripcion"]);

    $sql = "CALL crear_tarea('$titulo', '$descripcion')";
    
    if ($conexion->query($sql)) {
        echo json_encode(["message" => "Tarea agregada correctamente"]);
    } else {
        echo json_encode(["error" => "Error al insertar tarea: " . $conexion->error]);
    }
}

if ($method == "PUT") {
    parse_str(file_get_contents("php://input"), $_PUT);
    
    if (!isset($_PUT["id"]) || !is_numeric($_PUT["id"])) {
        echo json_encode(["error" => "ID inválido"]);
        exit;
    }

    $id = (int) $_PUT["id"];
    if (isset($_PUT["descripcion"])) {
        $descripcion = $conexion->real_escape_string($_PUT["descripcion"]);
        $sql = "CALL modificar_tarea($id, '$descripcion')";
        $conexion->query($sql);
        echo json_encode(["message" => "Tarea actualizada"]);
    } elseif (isset($_PUT["estado"])) {
        $estado = in_array($_PUT["estado"], ['pendiente', 'completada']) ? $_PUT["estado"] : 'pendiente';
        $sql = "CALL actualizar_tarea($id, '$estado')";
        $conexion->query($sql);
        echo json_encode(["message" => "Estado actualizado"]);
    }
}

if ($method == "DELETE") {
    if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
        echo json_encode(["error" => "ID inválido"]);
        exit;
    }

    $id = (int) $_GET["id"];
    $sql = "CALL eliminar_tarea($id)";
    $conexion->query($sql);
    echo json_encode(["message" => "Tarea eliminada"]);
}

$conexion->close();

include 'db.php';
if ($conexion->connect_error) {
    die(json_encode(["error" => "Error de conexión a la BD: " . $conexion->connect_error]));
} else {
    die(json_encode(["message" => "Conexión a MySQL exitosa"]));
}

?>
