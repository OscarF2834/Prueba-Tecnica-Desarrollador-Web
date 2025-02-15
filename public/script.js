document.addEventListener("DOMContentLoaded", () => {
    const tareaForm = document.getElementById("tareaForm");
    const listaTareas = document.getElementById("listaTareas");

    // Función para obtener tareas
    function cargarTareas() {
        fetch("backend/tareas.php")
            .then(res => res.json())
            .then(tareas => {
                listaTareas.innerHTML = "";
                tareas.forEach(tarea => {
                    listaTareas.innerHTML += `
                        <li>
                            <strong>${tarea.titulo}</strong>: ${tarea.descripcion} 
                            <button onclick="eliminarTarea(${tarea.id})">❌</button>
                        </li>
                    `;
                });
            });
    }

    // Agregar nueva tarea
    tareaForm.addEventListener("submit", e => {
        e.preventDefault();
        const titulo = document.getElementById("titulo").value;
        const descripcion = document.getElementById("descripcion").value;

        fetch("backend/tareas.php", {
            method: "POST",
            body: new URLSearchParams({ titulo, descripcion })
        }).then(() => {
            tareaForm.reset();
            cargarTareas();
        });
    });

    // Eliminar tarea
    window.eliminarTarea = function(id) {
        fetch("backend/tareas.php", {
            method: "DELETE",
            body: new URLSearchParams({ id })
        }).then(() => cargarTareas());
    };

    cargarTareas();
});
