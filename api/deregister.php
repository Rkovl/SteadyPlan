<?php
if($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    return;
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/repos/UserRepo.php';
try {
    $data = json_decode(file_get_contents("php://input"), true);

    if(!isset($data['id']) || !isset($data['confirm_text']) || !isset($data['password'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid parameters']);
        return;
    }
    $user_id = $data['id'];
    $password = $data['password'];

    $user = UserRepo::getUserById($user_id);
    if ($data['confirm_text'] !== 'DELETE') {
        echo json_encode(['error' => "You must type DELETE to confirm account deletion."]);
    } elseif (!password_verify($password, $user['password'])) {
        echo json_encode(['error' => "Password incorrect. Cannot delete account."]);
    } else {
        $result = UserRepo::deleteUser($user_id);
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
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}