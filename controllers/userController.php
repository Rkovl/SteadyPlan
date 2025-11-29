<?php

require_once(__DIR__ . "/../repos/userRepo.php");
require_once(__DIR__ . '/../db/verifyUUID.php');

class UserController {
    private $userRepo;

    function __construct() {
        $this->userRepo = new userRepo();
    }

    function register() {
        try {
            if($_SERVER["REQUEST_METHOD"] !== "POST") {
                http_response_code(405);
                echo json_encode(['error' => 'Method not POST']);
                return;
            }

            $data = json_decode(file_get_contents("php://input"), true);

            if ((!isset($data["email"]) && !isset($data["username"])) && !isset($data["password"])) {
                http_response_code(400);
                echo json_encode(['error' => 'Email or username and password are required']);
                return;
            }

            if(isset($data["email"]) && !filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {
                http_response_code(400);
                echo json_encode(['error' => 'Invalid email']);
                return;
            }

            if(strlen($data["password"]) < 8) {
                http_response_code(400);
                echo json_encode(['error' => 'Password must be at least 8 characters']);
                return;
            }

            if(isset($data["username"]) && $this->userRepo->getUserByUsername($data["username"])) {
                http_response_code(400);
                echo json_encode(['error' => 'Username already taken']);
                return;
            }

            if(isset($data["email"]) && $this->userRepo->getUserByEmail($data["email"])) {
              http_response_code(400);
              echo json_encode(['error' => 'Email already taken']);
              return;
            }

            $user = new User();
            $user->username = htmlspecialchars(trim($data["username"]));
            $user->email = isset($data["email"]) ? trim($data["email"]) : null;
            $user->password = password_hash($data["password"], PASSWORD_DEFAULT);

            $userId = $this->userRepo->register($user);

            if($userId) {
                http_response_code(201);
                echo json_encode([
                    'success' => true,
                    'message' => 'User registered successfully',
                    'userId' => $userId
                ]);
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'Failed to create user']);
            }

        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
        }
    }

    public function login() {
        try {
            if($_SERVER["REQUEST_METHOD"] !== "POST") {
                http_response_code(405);
                echo json_encode(['error' => 'Method not POST']);
                return;
            }

            $data = json_decode(file_get_contents("php://input"), true);
            $login = !empty($data["username"]) ? trim($data["username"]) : trim($data["email"]);
            $password = $data["password"];

            if (empty($login) || empty($data['password'])) {
                http_response_code(400);
                echo json_encode(['error' => 'Login and password required']);
                return;
            }

            $user = null;
            if(filter_var($login, FILTER_VALIDATE_EMAIL)) {
                $user = $this->userRepo->getUserByEmail($login);
            } else {
                $user = $this->userRepo->getUserByUsername($login);
            }

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
            $_SESSION['email'] = $user['email'];

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
    }

    public function logout() {
        try {
            if ($_SERVER["REQUEST_METHOD"] !== "POST") {
                http_response_code(405);
                echo json_encode(['error' => 'Method not POST']);
                return;
            }

            if (session_status() === PHP_SESSION_ACTIVE) {
                session_unset();
                session_destroy();
            }

            http_response_code(200);
            echo json_encode([
                'success' => true,
                'message' => 'Log out successful',
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
        }
    }

    public function getUserById($id) {
        try {
            if ($_SERVER["REQUEST_METHOD"] !== "POST") {
                http_response_code(405);
                echo json_encode(['error' => 'Method not POST']);
                return;
            }

            if(!$id) {
                http_response_code(405);
                echo json_encode(['error' => 'Invalid id']);
                return;
            }

            $user = $this->userRepo->getUserById($id);

            if($user) {
                unset($user['password']);

                http_response_code(200);
                echo json_encode($user);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'User not found']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
        }
    }

    public function updateUsername($id) {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'PUT' && $_SERVER['REQUEST_METHOD'] !== 'PATCH') {
                http_response_code(405);
                echo json_encode(['error' => 'Method not allowed']);
                return;
            }

            $data = json_decode(file_get_contents("php://input"), true);

            if(!isset($data['username'])) {
                http_response_code(400);
                echo json_encode(['error' => 'Invalid username']);
                return;
            }

            $username = htmlspecialchars(trim($data['username']));
            $result = $this->userRepo->updateUsername($username, $id);

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
    }

    public function updateEmail($id) {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'PUT' && $_SERVER['REQUEST_METHOD'] !== 'PATCH') {
                http_response_code(405);
                echo json_encode(['error' => 'Method not allowed']);
                return;
            }

            $data = json_decode(file_get_contents("php://input"), true);

            if(!isset($data['email'])) {
                http_response_code(400);
                echo json_encode(['error' => 'Invalid email']);
                return;
            }

            $email = trim($data['email']);
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                http_response_code(400);
                echo json_encode(['error' => 'Invalid email']);
                return;
            }

            $result = $this->userRepo->updateEmail($email, $id);

            if($result) {
                http_response_code(200);
                echo json_encode([
                    'success' => true,
                    'message' => 'Email updated successfully',
                ]);
            }  else {
                http_response_code(404);
                echo json_encode(['error' => 'Email not updated']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
        }
    }

    public function updatePassword($id) {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'PUT' && $_SERVER['REQUEST_METHOD'] !== 'PATCH') {
                http_response_code(405);
                echo json_encode(['error' => 'Method not allowed']);
                return;
            }

            $data = json_decode(file_get_contents("php://input"), true);

            if(!isset($data['password'])) {
                http_response_code(400);
                echo json_encode(['error' => 'Invalid password']);
                return;
            }

            if(strlen($data['password']) < 8) {
                http_response_code(400);
                echo json_encode(['error' => 'Password too short']);
                return;
            }

            $result = $this->userRepo->updatePassword($id, $data['password']);

            if($result) {
                http_response_code(200);
                echo json_encode([
                    'success' => true,
                    'message' => 'Password updated successfully',
                ]);
            }  else {
                http_response_code(404);
                echo json_encode(['error' => 'Password not updated']);
            }

        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
        }
    }

    public function deleteUser() {
        try {
            if($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
                http_response_code(405);
                echo json_encode(['error' => 'Method not allowed']);
                return;
            }

            $data = json_decode(file_get_contents("php://input"), true);

            if(!isset($data['id']) && !isset($data['username']) && !isset($data['email'])) {
                http_response_code(400);
                echo json_encode(['error' => 'Invalid parameters']);
                return;
            }

            if(!empty($data['id'])) {
                $result = $this->userRepo->deleteUser($data['id']);
            } else if (!empty($data['username'])) {
                $user = $this->userRepo->getUserByUsername($data['username']);
                if(!$user) {
                    http_response_code(404);
                    echo json_encode(['error' => 'User not found']);
                    return;
                }
                $result = $this->userRepo->deleteUser($user['id']);
            } else if (!empty($data['email'])) {
                $user = $this->userRepo->getUserByEmail($data['email']);
                if(!$user) {
                    http_response_code(404);
                    echo json_encode(['error' => 'User not found']);
                    return;
                }
                $result = $this->userRepo->deleteUser($user['id']);
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
    }
}