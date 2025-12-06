<?php
/* API endpoint to delete a task. */
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(['error' => 'Method not POST']);
    exit;
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/repos/TaskRepo.php');

try {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data["taskID"])) {
        http_response_code(400);
        echo json_encode(['error' => 'Task ID is required']);
        exit;
    }

    $taskID = $data["taskID"];

    $result = TaskRepo::deleteTask($taskID);

    if ($result) {
        http_response_code(200);
        echo json_encode([
            'success' => true,
            'message' => 'Task deleted successfully'
        ]);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Task not found or could not be deleted']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}

