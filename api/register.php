<?php
/*
 * API endpoint to register a new user.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/user.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/repos/userRepo.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit();
}

try {
    $data = json_decode(file_get_contents("php://input"), true);

    if ((!isset($data["email"]) && !isset($data["username"])) || !isset($data["password"])) {
        http_response_code(400);
        echo json_encode(['error' => 'All fields are required']);
        exit();
    }

    $username = htmlspecialchars(trim($data["username"]));
    $email = isset($data["email"]) ? trim($data["email"]) : null;
    $password = $data["password"];

    if (isset($data["email"]) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid email format']);
        exit();
    }

    if (strlen($password) < 8) {
        http_response_code(400);
        echo json_encode(['error' => 'Password must be at least 8 characters long']);
        exit();
    }

    if (UserRepo::getUserByUsername($username)) {
        http_response_code(409);
        echo json_encode(['error' => 'Username or email already exists']);
        exit();
    }

    if ($email && UserRepo::getUserByEmail($email)) {
        http_response_code(409);
        echo json_encode(['error' => 'Username or email already exists']);
        exit();
    }

    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $user = new User($username, $email, $password_hash, false);
    $userId = UserRepo::register($user);

    if ($userId) {
        http_response_code(201);
        echo json_encode([
            'success' => true,
            'message' => 'Registration successful',
            'userId' => $userId
        ]);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Registration failed']);
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}
exit();
