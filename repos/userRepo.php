<?php
require(__DIR__.'/models/user.php');
require(__DIR__.'/db/database.php');
class userRepo {
    private $db;

    public function __construct() {
        $database = new database();
        $this->db = $database->getConnection();
    }

    public function createUser($user) {
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

        $row = pg_fetch_array($result);
        return $row['id'];
    }
}