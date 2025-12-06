<?php
/* API endpoint to authenticate and login a user. */
require_once($_SERVER['DOCUMENT_ROOT'] . '/repos/TokensRepo.php');
if($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(['error' => 'Method not POST']);
    return;
}
require_once($_SERVER['DOCUMENT_ROOT'] . '/repos/UserRepo.php');
try {
    $data = json_decode(file_get_contents("php://input"), true);
    $login = !empty($data["username"]) ? trim($data["username"]) : trim($data["email"]);
    $password = $data["password"];

    if (empty($login) || empty($data['password'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Login and password required']);
        return;
    }

    $user = UserRepo::getUserByUsername($login);

    if(!$user || !password_verify($password, $user['password'])) {
        http_response_code(401);
        echo json_encode(['error' => 'Invalid login or password']);
        return;
    }

    if(session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];

    $remember_me = !empty($data['remember_me']) && ($data['remember_me'] === true);
    if($remember_me === true) {
        $token = bin2hex(random_bytes(32));
        $expiry_time = time() + (86400 * 30);
        $token_added = TokensRepo::addToken($user['id'], $token,  $expiry_time);

        if($token_added) {
            setcookie(
                'login_cookie',
                $token,
                [
                    'expires' => $expiry_time,
                    'path' => '/',
                    'httponly' => true,
                    'samesite' => 'Lax'
                ]
            );
        } else {
            error_log("Failed to store token for user" . $user['id']);
        }
    }

    unset($user['password']);

    http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => 'User logged in successfully',
        'user' => $user
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}