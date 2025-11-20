<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/db/database.php";
require_once "column-task.php";
$database = new Database();

function addColumn($id, $title) {
    echo "   
        <div class='column'>
            <h2>$title</h2>
            <div class='task_container' id='$id'>\n";
    loadTasksForColumn($id);
    echo "            </div>
            <button class='add-task-btn'><i class='bi bi-plus fs-4'></i> Add Task</button>
        </div>\n";
    saveColumn($id, $title);
}

function initializeDefaultBoard() {
    addColumn("todo", "To Do");
    addColumn("inprogress", "In Progress");
    addColumn("done", "Done");
}

function saveColumn($id, $title) {
    // db save logic can be added here in the future
}

function getProjectColumns($projectID) {
    // db load logic can be added here in the future
    global $database;
    // Fetch column UUIDs
    $stmt = $database->getConnection()->prepare("SELECT id, name FROM columns WHERE project_id = :projectID ORDER BY position");
    $stmt->bindParam(':projectID', $projectID);
    $stmt->execute();
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($columns) {
        foreach ($columns as $column) {
            addColumn($column['id'], $column['name']);
        }
    } else {
        initializeDefaultBoard();
    }
}

// load columns for test project
getProjectColumns('f31554b1-3a6e-44ad-b3a7-db9112878b8c');

