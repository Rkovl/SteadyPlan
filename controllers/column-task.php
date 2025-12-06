<?php
/*
 * Used to retrieving and dynamically generate column tasks.
 */
require_once ($_SERVER['DOCUMENT_ROOT'] . "/db/database.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/repos/taskRepo.php");

function renderTask($text, $taskID) {
    // create a new task element
    echo "                <div class='task' draggable='true' id ='$taskID'>
                    <span>$text</span>
                    <i class='delete-task bi bi-trash3 fs-6 ms-auto'></i>
                </div>\n";
}

function loadTasksForColumn($columnID) {
    $tasks = TaskRepo::getTasksFromColumn($columnID);
    if ($tasks) {
        foreach ($tasks as $task) {
            renderTask($task['name'], $task['id']);
        }
    }
}