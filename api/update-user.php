<?php
/*
 * API endpoint to update user details.
 */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    return;
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/repos/UserRepo.php';
try {
    if(session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        echo json_encode(['error' => 'Unauthorized']);
        return;
    }
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['update_type']) || !isset($data['password'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid parameters']);
        return;
    }
    $user_id = $_SESSION['user_id'];
    $user = UserRepo::getUserById($user_id);
    if (!password_verify($data['password'], $user['password'])) {
        http_response_code(401);
        echo json_encode(['error' => 'Password incorrect']);
        return;
    }

    $update_type = $data['update_type'];
    $message = '';
    // check which is present, email username, or password
    if ($data['update_type'] === 'account_info' && isset ($data['username']) && isset ($data['email'])) {
        $email = trim($data['email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid email']);
            return;
        }

        $username = htmlspecialchars(trim($data['username']));
        $result = UserRepo::updateUsername($user_id, $username);
        if (!$result) {
            http_response_code(409);
            echo json_encode(['error' => 'Username already exists']);
            return;
        }
        $result = UserRepo::updateEmail($user_id, $email);
        if (!$result) {
            http_response_code(409);
            echo json_encode(['error' => 'Email already exists']);
            return;
        }
        $message = 'Account updated successfully';
    } else if ($data['update_type'] === 'password' && isset ($data['new_password'])) {
        $new_password = $data['new_password'];
        if ($new_password !== $data['confirm_password']) {
            http_response_code(400);
            echo json_encode(['error' => 'Passwords do not match']);
            return;
        }
        if (strlen($new_password) < 8) {
            http_response_code(400);
            echo json_encode(['error' => 'Password must be at least 8 characters long']);
            return;
        }
        $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
        $result = UserRepo::updatePassword($user_id, $new_password_hash);
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