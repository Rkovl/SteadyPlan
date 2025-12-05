<?php
if ($_SERVER['REQUEST_METHOD'] !== 'PUT' && $_SERVER['REQUEST_METHOD'] !== 'PATCH') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    return;
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/repos/UserRepo.php';
try {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['id']) || !isset($data['update_type']) || !isset($data['password'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid parameters']);
        return;
    }
    $user_id = $data['id'];
    $user = UserRepo::getUserById($user_id);
    if (!password_verify($data['password'], $user['password'])) {
        http_response_code(401);
        echo json_encode(['error' => 'Password incorrect']);
        return;
    }

    $update_type = $data['update_type'];
    $message = '';
    // check which is present, email username, or password
    if ($data['update_type'] === 'username' && isset ($data['username'])) {
        $username = htmlspecialchars(trim($data['username']));
        $result = UserRepo::updateUsername($data['id'], $username);
        if ($result) {
            $message = 'Username updated successfully';
        }
    } else if ($data['update_type'] === 'email' && isset ($data['email'])) {
        $email = trim($data['email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid email']);
            return;
        }
        $result = UserRepo::updateEmail($data['id'], $email);
        if ($result) {
            $message = 'Email updated successfully';
        }
    } else if ($data['update_type'] === 'password' && isset ($data['new_password'])) {
        $new_password = $data['new_password'];
        if (strlen($new_password) < 8) {
            http_response_code(400);
            echo json_encode(['error' => 'Password must be at least 8 characters long']);
            return;
        }
        $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
        $result = UserRepo::updatePassword($data['id'], $new_password_hash);
        if ($result) {
            $message = 'Password updated successfully';
        }
    }
    if (isset($result) && $result) {
        http_response_code(200);
        echo json_encode([
            'success' => true,
            'message' => $message,
        ]);
        return;
    }
    http_response_code(400);
    echo json_encode(['error' => 'No valid fields to update']);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}