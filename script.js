document.getElementById('taskForm').addEventListener('submit', function(event) {
    event.preventDefault();
    const title = document.getElementById('taskTitle').value;
    const description = document.getElementById('taskDescription').value;

    fetch('php/create_task.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert(data.message);
            loadTasks();
        } else {
            alert(data.message);
        }
    });
});

function loadTasks() {
    fetch('php/get_tasks.php')
    .then(response => response.json())
    .then(tasks => {
        const taskList = document.getElementById('taskList');
        taskList.innerHTML = '';
        tasks.forEach(task => {
            const li = document.createElement('li');
            li.innerHTML = `
                <h3>${task.title}</h3>
                <p>${task.description}</p>
                <button onclick="completeTask(${task.id})">Completar</button>
                <button onclick="deleteTask(${task.id})">Eliminar</button>
            `;
            taskList.appendChild(li);
        });
    });
}

function completeTask(id) {
    fetch('php/complete_task.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `id=${id}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert(data.message);
            loadTasks();
        } else {
            alert(data.message);
        }
    });
}

function deleteTask(id) {
    fetch('php/delete_task.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `id=${id}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert(data.message);
            loadTasks();
        } else {
            alert(data.message);
        }
    });
}

// Cargar tareas al iniciar
loadTasks();