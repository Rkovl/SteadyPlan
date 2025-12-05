<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . "/db/database.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/repos/taskRepo.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        if ($action === 'addTask' && isset($_POST['text']) && isset($_POST['columnID'])) {
            $text = $_POST['text'];
            // Insert task into database
            $taskID = TaskRepo::createTask(0, $_POST['columnID'], $text); // Assuming projectID is 0 for now
            addTask($text, $taskID);
        } elseif ($action === 'deleteTask' && isset($_POST['taskID'])) {
            // Delete task from database
            TaskRepo::deleteTask($_POST['taskID']);
        } elseif ($action === 'moveTask' && isset($_POST['taskID']) && isset($_POST['newColumnID'])) {
            // Update task in database
            TaskRepo::changeColumn($_POST['newColumnID'], $_POST['taskID']);
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
    $tasks = TaskRepo::getTasksFromColumn($columnID);
    if ($tasks) {
        foreach ($tasks as $task) {
            addTask($task['name'], $task['id']);
        }
    }
}