<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(['error' => 'Method not POST']);
    exit;
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/repos/TaskRepo.php');

try {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data["columnID"]) || !isset($data["text"]) || !isset($data["projectID"])) {
        http_response_code(400);
        echo json_encode(['error' => 'Column ID, text, and project ID are required']);
        exit;
    }

    $projectID = $data["projectID"];
    $columnID = $data["columnID"];
    $text = $data["text"];
    $description = $data["description"] ?? null;

    $taskID = TaskRepo::createTask($projectID, $columnID, $text, $description);

    http_response_code(201);
    echo json_encode([
        'success' => true,
        'taskID' => $taskID,
        'message' => 'Task created successfully'
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}

