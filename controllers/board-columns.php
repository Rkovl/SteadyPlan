<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . "/db/database.php");
require_once ("column-task.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/repos/columnRepo.php");

function addColumn($id, $title) {
    echo "   
        <div class='column'>
            <h2>$title</h2>
            <div class='task_container' id='$id'>\n";
    loadTasksForColumn($id);
    echo "            </div>
            <button class='add-task-btn'><i class='bi bi-plus fs-4'></i> Add Task</button>
        </div>\n";
}

function initializeDefaultBoard($projectID) {
    // Create default columns in the database
    $todoID = ColumnRepo::addColumn($projectID, "To Do", 0);
    $inProgressID = ColumnRepo::addColumn($projectID, "In Progress", 1);
    $doneID = ColumnRepo::addColumn($projectID, "Done", 2);

    // Render the columns
    if ($todoID) addColumn($todoID, "To Do");
    if ($inProgressID) addColumn($inProgressID, "In Progress");
    if ($doneID) addColumn($doneID, "Done");
}

function getColumns($projectID) {
    $columns = ColumnRepo::getProjectColumns($projectID);

    if ($columns && count($columns) > 0) {
        foreach ($columns as $column) {
            addColumn($column['id'], $column['name']);
        }
    } else {
        initializeDefaultBoard($projectID);
    }
}

// load columns for project from POST or GET
$projectID = $_POST['projectID'] ?? $_GET['projectID'] ?? null;

if ($projectID) {
    getColumns($projectID);
} else {
    echo "<p class='text-danger'>Error: Project ID is required</p>";
}

