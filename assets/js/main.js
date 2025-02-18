document.addEventListener('DOMContentLoaded', function() {
    // Formulario para agregar tareas
    const taskForm = document.getElementById('task-form');
    const taskList = document.getElementById('task-list');
    
    // Evento para crear una nueva tarea
    taskForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const title = document.getElementById('title').value;
        const description = document.getElementById('description').value;
        
        fetch('/api/create_task.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ title, description })
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            location.reload(); // Recargar para mostrar la nueva tarea
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Ocurrió un error al crear la tarea.');
        });
    });
    
    // Eventos para botones de tareas
    if (taskList) {
        taskList.addEventListener('click', function(e) {
            // Completar tarea
            if (e.target.classList.contains('complete-task')) {
                const id = e.target.getAttribute('data-id');
                completeTask(id);
            }
            
            // Eliminar tarea
            if (e.target.classList.contains('delete-task')) {
                const id = e.target.getAttribute('data-id');
                deleteTask(id);
            }
            
            // Editar tarea
            if (e.target.classList.contains('edit-task')) {
                const id = e.target.getAttribute('data-id');
                const title = e.target.getAttribute('data-title');
                const description = e.target.getAttribute('data-description');
                
                // Rellenar el modal con los datos actuales
                document.getElementById('edit-task-id').value = id;
                document.getElementById('edit-title').value = title;
                document.getElementById('edit-description').value = description;
                
                // Mostrar el modal
                $('#editTaskModal').modal('show');
            }
        });
    }
    
    // Guardar edición de tarea
    document.getElementById('save-edit').addEventListener('click', function() {
        const id = document.getElementById('edit-task-id').value;
        const title = document.getElementById('edit-title').value;
        const description = document.getElementById('edit-description').value;
        
        updateTask(id, title, description);
    });
    
    // Función para completar tarea
    function completeTask(id) {
        if (confirm('¿Estás seguro de marcar esta tarea como completada?')) {
            fetch('api/complete_task.php', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id })
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Ocurrió un error al completar la tarea.');
            });
        }
    }
    
    // Función para eliminar tarea
    function deleteTask(id) {
        if (confirm('¿Estás seguro de eliminar esta tarea?')) {
            fetch('api/delete_task.php', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id })
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Ocurrió un error al eliminar la tarea.');
            });
        }
    }
    
    // Función para actualizar tarea
    function updateTask(id, title, description) {
        fetch('api/update_task.php', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id, title, description })
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            $('#editTaskModal').modal('hide');
            location.reload();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Ocurrió un error al actualizar la tarea.');
        });
    }
});