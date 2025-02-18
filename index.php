<?php
require_once 'controllers/TaskController.php';
$taskController = new TaskController();
$tasks = $taskController->getAllTasks();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Tareas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Gestor de Tareas</h1>
        
        <!-- Formulario para agregar tareas -->
        <div class="card mb-4">
            <div class="card-header">
                <h2 class="h5 mb-0">Agregar Nueva Tarea</h2>
            </div>
            <div class="card-body">
                <form id="task-form">
                    <div class="form-group">
                        <label for="title">Título</label>
                        <input type="text" class="form-control" id="title" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Descripción</label>
                        <textarea class="form-control" id="description"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
        
        <!-- Lista de tareas -->
        <div class="card">
            <div class="card-header">
                <h2 class="h5 mb-0">Mis Tareas</h2>
            </div>
            <div class="card-body">
                <ul id="task-list" class="list-group">
                    <?php foreach($tasks as $task): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center <?php echo $task['status'] === 'completada' ? 'bg-light text-muted' : ''; ?>">
                        <div>
                            <h3 class="h6 mb-1"><?php echo htmlspecialchars($task['title']); ?></h3>
                            <p class="mb-0 small"><?php echo htmlspecialchars($task['description']); ?></p>
                        </div>
                        <div class="btn-group">
                            <?php if($task['status'] !== 'completada'): ?>
                            <button class="btn btn-sm btn-success complete-task" data-id="<?php echo $task['id']; ?>">Completar</button>
                            <button class="btn btn-sm btn-warning edit-task" data-id="<?php echo $task['id']; ?>" 
                                data-title="<?php echo htmlspecialchars($task['title']); ?>" 
                                data-description="<?php echo htmlspecialchars($task['description']); ?>">Editar</button>
                            <?php endif; ?>
                            <button class="btn btn-sm btn-danger delete-task" data-id="<?php echo $task['id']; ?>">Eliminar</button>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
                
                <?php if(empty($tasks)): ?>
                <p class="text-center mt-3">No hay tareas pendientes.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Modal para editar tarea -->
    <div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTaskModalLabel">Editar Tarea</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="edit-task-form">
                        <input type="hidden" id="edit-task-id">
                        <div class="form-group">
                            <label for="edit-title">Título</label>
                            <input type="text" class="form-control" id="edit-title" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-description">Descripción</label>
                            <textarea class="form-control" id="edit-description"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="save-edit">Guardar Cambios</button>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>