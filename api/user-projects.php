<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/repos/projectRepo.php';

header('Content-Type: application/json');

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
    $projects = ProjectRepo::getProjectsByUserId($_SESSION['user_id']);
    http_response_code(200);
    echo json_encode(['projects' => $projects]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}
exit();
