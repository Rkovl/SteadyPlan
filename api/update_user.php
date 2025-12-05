<?php
if ($_SERVER['REQUEST_METHOD'] !== 'PUT' && $_SERVER['REQUEST_METHOD'] !== 'PATCH') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    return;
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/repos/UserRepo.php';
try {
    $data = json_decode(file_get_contents("php://input"), true);

    if(!isset($data['id'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid id']);
        return;
    }
    // check which is present, email username, or password
    if (isset ($data['username'])) {
        $username = htmlspecialchars(trim($data['username']));
        $result = UserRepo::updateUsername($data['id'], $username);
    } else if (isset ($data['email'])) {
        $email = trim($data['email']);
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid email']);
            return;
        }
        $result = UserRepo::updateEmail($data['id'], $email);
    } else if (isset ($data['password'])) {
        $password = $data['password'];
        if (strlen($password) < 8) {
            http_response_code(400);
            echo json_encode(['error' => 'Password must be at least 8 characters long']);
            return;
        }
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $result = UserRepo::updatePassword($data['id'], $password_hash);
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'No valid fields to update']);
        return;
    }

    if($result) {
        http_response_code(200);
        echo json_encode([
            'success' => true,
            'message' => 'Username updated successfully',
        ]);
    }  else {
        http_response_code(404);
        echo json_encode(['error' => 'Username not updated']);
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}