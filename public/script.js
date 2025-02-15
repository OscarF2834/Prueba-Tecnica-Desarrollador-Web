const API_URL = "https://jsonplaceholder.typicode.com/todos"; // API simulada

document.addEventListener("DOMContentLoaded", fetchTasks);

async function fetchTasks() {
    const response = await fetch(API_URL + "?userId=1&_limit=5");
    const tasks = await response.json();
    const taskList = document.getElementById("taskList");
    taskList.innerHTML = "";
    tasks.forEach(task => {
        addTaskToDOM(task.title, task.completed);
    });
}

async function addTask() {
    let taskText = document.getElementById("taskInput").value;
    if (taskText.trim() === "") return;
    
    const response = await fetch(API_URL, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ title: taskText, completed: false })
    });
    const newTask = await response.json();
    addTaskToDOM(newTask.title, newTask.completed);
    document.getElementById("taskInput").value = "";
}

function addTaskToDOM(text, completed) {
    let taskList = document.getElementById("taskList");
    let listItem = document.createElement("li");
    listItem.className = "list-group-item d-flex justify-content-between align-items-center";
    
    listItem.innerHTML = `
        <span class="task-text ${completed ? 'completed' : ''}">${text}</span>
        <div>
            <button class="btn btn-outline-secondary btn-sm" onclick="editTask(this)">✏️</button>
            <button class="btn btn-outline-success btn-sm" onclick="toggleComplete(this)">✔️</button>
            <button class="btn btn-outline-danger btn-sm" onclick="deleteTask(this)">❌</button>
        </div>
    `;
    
    taskList.appendChild(listItem);
}

async function deleteTask(button) {
    const taskText = button.parentElement.parentElement.querySelector(".task-text").textContent;
    await fetch(API_URL + "/1", { method: "DELETE" });
    button.parentElement.parentElement.remove();
}

async function toggleComplete(button) {
    let taskText = button.parentElement.parentElement.querySelector(".task-text");
    const completed = !taskText.classList.contains("completed");
    await fetch(API_URL + "/1", {
        method: "PATCH",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ completed })
    });
    taskText.classList.toggle("completed");
}

async function editTask(button) {
    let taskText = button.parentElement.parentElement.querySelector(".task-text");
    let newText = prompt("Editar tarea:", taskText.textContent);
    if (newText !== null && newText.trim() !== "") {
        await fetch(API_URL + "/1", {
            method: "PATCH",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ title: newText })
        });
        taskText.textContent = newText;
    }
}