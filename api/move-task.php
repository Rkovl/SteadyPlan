<?php
/*
 * API endpoint to move a task between columns.
 */
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(['error' => 'Method not POST']);
    return;
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/repos/TaskRepo.php');

try {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data["taskID"]) || !isset($data["newColumnID"])) {
        http_response_code(400);
        echo json_encode(['error' => 'Task ID and new column ID are required']);
        exit;
    }

    $taskID = $data["taskID"];
    $newColumnID = $data["newColumnID"];

    $result = TaskRepo::changeColumn($newColumnID, $taskID);

    if ($result) {
        http_response_code(200);
        echo json_encode([
            'success' => true,
            'message' => 'Task moved successfully'
        ]);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Task not found or could not be moved']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}

