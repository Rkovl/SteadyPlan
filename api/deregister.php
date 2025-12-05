<?php
if($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    return;
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/repos/UserRepo.php';
try {
    $data = json_decode(file_get_contents("php://input"), true);

    if(!isset($data['id']) && !isset($data['username']) && !isset($data['email'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid parameters']);
        return;
    }

    if(!empty($data['id'])) {
        $result = UserRepo::deleteUser($data['id']);
    } else if (!empty($data['username'])) {
        $user = UserRepo::getUserByUsername($data['username']);
        if(!$user) {
            http_response_code(404);
            echo json_encode(['error' => 'User not found']);
            return;
        }
        $result = UserRepo::deleteUser($user['id']);
    } else if (!empty($data['email'])) {
        $user = UserRepo::getUserByEmail($data['email']);
        if(!$user) {
            http_response_code(404);
            echo json_encode(['error' => 'User not found']);
            return;
        }
        $result = UserRepo::deleteUser($user['id']);
    }

    if($result) {
        http_response_code(200);
        echo json_encode([
            'success' => true,
            'message' => 'User deleted successfully',
        ]);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'User not found']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}