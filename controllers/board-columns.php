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
    saveColumn($id, $title);
}

function initializeDefaultBoard() {
    global $project;
    addColumn($project, "To Do",0);
    addColumn($project, "In Progress",1);
    addColumn($project, "Done",2);
}

function saveColumn($id, $title) {
    // db save logic can be added here in the future
}

function getColumns($projectID) {
    $columns = ColumnRepo::getProjectColumns($projectID);

    if ($columns) {
        foreach ($columns as $column) {
            addColumn($column['id'], $column['name']);
        }
    } else {
       initializeDefaultBoard();
    }
}

if (isset($_GET['project'])) {
    $project = $_GET['project'];
}

// load columns for test project
getColumns($project);

