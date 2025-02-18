<?php
require_once 'models/Task.php';

class TaskController {
    private $task;
    
    public function __construct() {
        $this->task = new Task();
    }
    
    public function getAllTasks() {
        $stmt = $this->task->read();
        $tasks = [];
        
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $tasks[] = $row;
        }
        
        return $tasks;
    }
}
?>