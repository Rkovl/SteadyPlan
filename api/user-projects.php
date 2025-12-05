<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/repos/ProjectRepo.php';

header('Content-Type: application/json');
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit();
}


try {
    $userID = $_SESSION['user_id'];
    if (isAdmin()) {
        $projects = ProjectRepo::getAllProjects($userID);
    } else {
        $projects = ProjectRepo::getProjectsInformationByUserId($userID);
    }

    http_response_code(200);
    echo json_encode(['projects' => $projects]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}
exit();
