<?php
require_once 'config/database.php';

class Task {
    private $conn;
    private $table_name = "tasks";
    
    public $id;
    public $title;
    public $description;
    public $status;
    public $created_at;
    public $updated_at;
    
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    
    // Crear tarea
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                 (title, description) 
                 VALUES (:title, :description)";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitizar datos
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->description = htmlspecialchars(strip_tags($this->description));
        
        // Vincular valores
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":description", $this->description);
        
        // Ejecutar consulta
        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }
    
    // Leer todas las tareas
    public function read() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }
    
    // Leer una tarea específica
    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($row) {
            $this->id = $row['id'];
            $this->title = $row['title'];
            $this->description = $row['description'];
            $this->status = $row['status'];
            $this->created_at = $row['created_at'];
            $this->updated_at = $row['updated_at'];
            return true;
        }
        
        return false;
    }
    
    // Actualizar tarea
    public function update() {
        $query = "UPDATE " . $this->table_name . "
                 SET title = :title, description = :description
                 WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitizar datos
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->id = htmlspecialchars(strip_tags($this->id));
        
        // Vincular valores
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":id", $this->id);
        
        // Ejecutar consulta
        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }
    
    // Eliminar tarea
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        
        // Sanitizar id
        $this->id = htmlspecialchars(strip_tags($this->id));
        
        // Vincular id
        $stmt->bindParam(":id", $this->id);
        
        // Ejecutar consulta
        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }
    
    // Completar tarea
    public function complete() {
        $query = "UPDATE " . $this->table_name . "
                 SET status = 'completada'
                 WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitizar id
        $this->id = htmlspecialchars(strip_tags($this->id));
        
        // Vincular id
        $stmt->bindParam(":id", $this->id);
        
        // Ejecutar consulta
        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }
}
?>