<?php
include 'db.php';  // Primero incluimos la conexión a la base de datos

header('Content-Type: application/json'); // Ahora configuramos el encabezado JSON

// Obtenemos todas las tareas
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $pdo->prepare("SELECT * FROM tasks");
    $stmt->execute();
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($tasks);
    exit(); // Finalizamos aquí para evitar salida adicional
}

// Crear una nueva tarea
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $pdo->prepare("INSERT INTO tasks (title, description, status) VALUES (:title, :description, :status)");
    $stmt->bindParam(':title', $data['title']);
    $stmt->bindParam(':description', $data['description']);
    $stmt->bindParam(':status', $data['status'], PDO::PARAM_BOOL);
    if ($stmt->execute()) {
        echo json_encode(["message" => "Tarea creada con éxito"]);
    } else {
        echo json_encode(["message" => "Error al crear la tarea"]);
    }
    exit();
}

// Actualizar una tarea
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $pdo->prepare("UPDATE tasks SET title = :title, description = :description, status = :status WHERE id = :id");
    $stmt->bindParam(':title', $data['title']);
    $stmt->bindParam(':description', $data['description']);
    $stmt->bindParam(':status', $data['status'], PDO::PARAM_BOOL);
    $stmt->bindParam(':id', $data['id'], PDO::PARAM_INT);
    if ($stmt->execute()) {
        echo json_encode(["message" => "Tarea actualizada con éxito"]);
    } else {
        echo json_encode(["message" => "Error al actualizar la tarea"]);
    }
    exit();
}

// Eliminar una tarea
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = :id");
    $stmt->bindParam(':id', $data['id'], PDO::PARAM_INT);
    if ($stmt->execute()) {
        echo json_encode(["message" => "Tarea eliminada con éxito"]);
    } else {
        echo json_encode(["message" => "Error al eliminar la tarea"]);
    }
    exit();
}

