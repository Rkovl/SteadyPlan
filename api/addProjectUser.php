<?php
/* API endpoint to add a user to a project. */
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(['error' => 'Method not POST']);
    exit();
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/repos/UserRepo.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/repos/ProjectUserRepo.php');
try {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data["project_id"]) || !isset($data["username"])) {
        http_response_code(400);
        echo json_encode(['error' => 'Project id and username are required']);
        exit();
    }

    $project = $data["project_id"];
    $name = $data["username"];
    $user = UserRepo::getUserByUsername($name);
    if (!$user) {
        http_response_code(404);
        echo json_encode(['error' => 'User not found']);
        exit();
    }
    $user_id = $user['id'];

    // check if user is already in project
    $existingUsers = ProjectUserRepo::getProjectUsers($project);
    foreach ($existingUsers as $user) {
        if ($user['user_id'] == $user_id) {
            http_response_code(409);
            echo json_encode(['error' => 'User is already a member of the project']);
            exit();
        }
    }

    ProjectUserRepo::addProjectUser($project, $user_id);
    http_response_code(200);
    echo json_encode(['message' => 'User added to project successfully']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}
exit();