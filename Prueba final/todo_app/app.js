const apiUrl = 'http://localhost/Prueba%20final/todo_app/index.php';

// Obtener y mostrar todas las tareas
async function getTasks() {
    try {
        const response = await fetch(apiUrl);
        if (!response.ok) {
            throw new Error('Error al obtener las tareas');
        }
        const tasks = await response.json();
        const tasksList = document.getElementById('tasks-list');
        tasksList.innerHTML = '';
        tasks.forEach(task => {
            const taskItem = document.createElement('li');
            taskItem.innerHTML = `
                <span>${task.title}: ${task.description}</span>
                <button onclick="deleteTask(${task.id})">Eliminar</button>
            `;
            tasksList.appendChild(taskItem);
        });
    } catch (error) {
        console.error('Error:', error.message);
    }
}

// Crear una nueva tarea
async function createTask() {
    const title = document.getElementById('title').value;
    const description = document.getElementById('description').value;

    if (title && description) {
        try {
            const response = await fetch(apiUrl, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ title, description, status: false })
            });
            if (!response.ok) {
                throw new Error('Error al crear la tarea');
            }
            getTasks(); // Llamamos correctamente a getTasks aquí
        } catch (error) {
            console.error('Error:', error.message);
        }
    }
}

// Eliminar una tarea
async function deleteTask(id) {
    try {
        const response = await fetch(apiUrl, {
            method: 'DELETE',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id })
        });
        if (!response.ok) {
            throw new Error('Error al eliminar la tarea');
        }
        getTasks();
    } catch (error) {
        console.error('Error:', error.message);
    }
}

// Llamar a getTasks al cargar la página
window.onload = getTasks;

