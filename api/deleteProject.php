<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(['error' => 'Method not POST']);
    return;
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/repos/ProjectRepo.php');
try {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data["project_id"])) {
        http_response_code(400);
        echo json_encode(['error' => 'Project owner and name are required']);
    }

    $project_id = $data["project_id"];

    ProjectRepo::deleteProject($project_id);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}