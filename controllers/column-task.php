<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/db/database.php";
$database = new Database();
if ($database->getConnection() === null) {
    die("Database connection failed.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        if ($action === 'addTask' && isset($_POST['text']) && isset($_POST['columnID'])) {
            $text = $_POST['text'];
            $columnID = $_POST['columnID'];
            // Insert task into database
            $stmt = $database->getConnection()->prepare("INSERT INTO tasks (description, column_id) VALUES (:description, :column_id)");
            $stmt->bindParam(':description', $text);
            $stmt->bindParam(':column_id', $columnID);
            $stmt->execute();
            $taskID = $database->getConnection()->lastInsertId();
            addTask($text, $taskID);
        } elseif ($action === 'deleteTask' && isset($_POST['taskID'])) {
            $taskID = $_POST['taskID'];
            // Delete task from database
            $stmt = $database->getConnection()->prepare("DELETE FROM tasks WHERE id = :id");
            $stmt->bindParam(':id', $taskID);
            $stmt->execute();
        } elseif ($action === 'moveTask' && isset($_POST['taskID']) && isset($_POST['newColumnID'])) {
            $taskID = $_POST['taskID'];
            $newColumnID = $_POST['newColumnID'];
            // Update task in database
            $stmt = $database->getConnection()->prepare("UPDATE tasks SET column_id = :column_id WHERE id = :id");
            $stmt->bindParam(':column_id', $newColumnID);
            $stmt->bindParam(':id', $taskID);
            $stmt->execute();
        } else {
            http_response_code(400);
            echo "Invalid action or missing parameters.";
        }
    }
}

function addTask($text, $taskID) {
    // create a new task element
    echo "                <div class='task' draggable='true' id ='$taskID'>
                    <span>$text</span>
                    <i class='delete-task bi bi-trash3 fs-6 ms-auto'></i>
                </div>\n";
}

function loadTasksForColumn($columnID) {
    // db load logic can be added here in the future
    global $database;
    $stmt = $database->getConnection()->prepare("SELECT id, name FROM tasks WHERE column_id = :columnID");
    $stmt->bindParam(':columnID', $columnID);
    $stmt->execute();
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($tasks) {
        foreach ($tasks as $task) {
            addTask($task['name'], $task['id']);
        }
    }
}