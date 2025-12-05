<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/db/database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/repos/BaseRepo.php');

class UserRepo extends BaseRepo
{
    public static function register($user)
    {
        $query = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password) RETURNING id";

        $stmt = BaseRepo::getDB()->prepare($query);
        $stmt->bindParam(':username', $user->username);
        $stmt->bindParam(':email', $user->email);
        $stmt->bindParam(':password', $user->password);

        if (!$stmt->execute()) {
            return null;
        }

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['id'];
    }

    public static function getUserById($id)
    {
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = BaseRepo::getDB()->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getUserByUsername($username)
    {
        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = BaseRepo::getDB()->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getUserByEmail($email)
    {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = BaseRepo::getDB()->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function updateUsername($id, $username)
    {
        try {
            $query = "UPDATE users SET username = :username WHERE id = :id";
            $stmt = BaseRepo::getDB()->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            // Check if it's a unique constraint violation
            if ($e->getCode() == '23505') {
                return false;
            }
            // Re-throw other exceptions
            throw $e;
        }
    }

    public static function updateEmail($id, $email)
    {
        try {
            $query = "UPDATE users SET email = :email WHERE id = :id";
            $stmt = BaseRepo::getDB()->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            // Check if it's a unique constraint violation
            if ($e->getCode() == '23505') {
                return false;
            }
            // Re-throw other exceptions
            throw $e;
        }
    }

    public static function updatePassword($id, $password)
    {
        $query = "UPDATE users SET password = :password WHERE id = :id";
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = BaseRepo::getDB()->prepare($query);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public static function deleteUser($id)
    {
        $query = "DELETE FROM users WHERE id = :id";
        $stmt = BaseRepo::getDB()->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}

