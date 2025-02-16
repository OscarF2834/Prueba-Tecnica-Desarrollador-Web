const API_URL = "http://localhost:8000/backend/tareas.php"; // Ruta al backend en PHP

document.addEventListener("DOMContentLoaded", fetchTasks);

async function fetchTasks() {
    try {
        const response = await fetch(API_URL);
        const tasks = await response.json();
        console.log("Tareas obtenidas:", tasks); // Depuración
        const taskList = document.getElementById("taskList");
        taskList.innerHTML = "";
        tasks.forEach(task => {
            addTaskToDOM(task.id, task.titulo, task.descripcion, task.estado);
        });
    } catch (error) {
        console.error("Error al obtener tareas:", error);
    }
}

async function addTask() {
    let titulo = document.getElementById("taskInput").value;
    let descripcion = "Nueva tarea"; // Puedes modificar para ingresar descripción

    if (titulo.trim() === "") return;

    try {
        const response = await fetch(API_URL, {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: new URLSearchParams({ titulo, descripcion })
        });

        const result = await response.json();
        console.log("Respuesta del servidor:", result); // Depuración

        if (result.message) {
            fetchTasks(); // Recargar la lista
        } else {
            console.error("Error al agregar tarea:", result.error);
        }
    } catch (error) {
        console.error("Error en la solicitud:", error);
    }

    document.getElementById("taskInput").value = "";
}

function addTaskToDOM(id, titulo, descripcion, estado) {
    let taskList = document.getElementById("taskList");
    let listItem = document.createElement("li");
    listItem.className = "list-group-item d-flex justify-content-between align-items-center";

    listItem.innerHTML = `
        <span class="task-text ${estado === 'completada' ? 'completed' : ''}">${titulo} - ${descripcion}</span>
        <div>
            <button class="btn btn-outline-secondary btn-sm" onclick="editTask(${id}, this)">✏️</button>
            <button class="btn btn-outline-success btn-sm" onclick="toggleComplete(${id}, this)">✔️</button>
            <button class="btn btn-outline-danger btn-sm" onclick="deleteTask(${id}, this)">❌</button>
        </div>
    `;

    taskList.appendChild(listItem);
}
