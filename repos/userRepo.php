<?php
require_once(__DIR__ . '/../models/user.php');
require_once(__DIR__ . '/../db/database.php');
class userRepo {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function register($user) {
        $query = "INSERT INTO users (username, email, password) VALUES ($1, $2, $3) RETURNING id";

        $hashedPassword = password_hash($user->password, PASSWORD_DEFAULT);

        $result = pg_query_params(
            $this->db,
            $query,
            array($user->username,
                $user->email,
                $hashedPassword
            )
        );

        if(!$result) {
            return null;
        }

        $row = pg_fetch_assoc($result);
        return $row['id'];
    }

    public function getUserById($id) {
        $query = "SELECT * FROM users WHERE id = $1";

        $result = pg_query_params($this->db, $query, array($id));

        if(!$result) {
            return null;
        }

        return pg_fetch_assoc($result);
    }

    public function getUserByUsername($username) {
        $query = "SELECT * FROM users WHERE username = $1";

        $result = pg_query_params($this->db, $query, array($username));

        if(!$result) {
            return null;
        }

        return pg_fetch_assoc($result);
    }

    public function getUserByEmail($email) {
        $query = "SELECT * FROM users WHERE username = $1";

        $result = pg_query_params($this->db, $query, array($email));

        if(!$result) {
            return null;
        }

        return pg_fetch_assoc($result);
    }

    public function updateUsername($username, $id) {
        $query = "UPDATE users SET username = $1 WHERE id = $2";

        $result = pg_query_params($this->db, $query, array($username, $id));

        return $result != false;
    }

    public function updateEmail($email, $id) {
        $query = "UPDATE users SET email = $1 WHERE id = $2";

        $result = pg_query_params($this->db, $query, array($email, $id));

        return $result != false;
    }

    public function updatePassword($password, $id) {
        $query = "UPDATE users SET password = $1 WHERE id = $2";
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $result = pg_query_params($this->db, $query, array($hashedPassword, $id));

        return $result != false;
    }

    public function deleteUser($id) {
        $query = "DELETE FROM users WHERE id = $1";

        $result = pg_query_params($this->db, $query, array($id));

        return $result != false;
    }
}