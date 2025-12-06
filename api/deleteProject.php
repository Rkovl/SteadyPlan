<?php
header('Content-Type: application/json');
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(['error' => 'Method not POST']);
    exit();
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/db/auth.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/repos/ProjectRepo.php');
try {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data["project_id"])) {
        http_response_code(400);
        echo json_encode(['error' => 'Project id are required']);
        exit();
    }

    $project_id = $data["project_id"];

    $success = ProjectRepo::deleteProject($project_id, $_SESSION['user_id'], isAdmin());
    if (!$success) {
        http_response_code(403);
        echo json_encode(['error' => 'Unauthorized to delete this project']);
        exit();
    }

    http_response_code(200);
    echo json_encode(['success' => true, 'message' => 'Project deleted successfully']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}
exit();