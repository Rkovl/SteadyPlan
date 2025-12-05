<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/db/database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/repos/BaseRepo.php');

class TokensRepo extends BaseRepo
{
    public static function addToken($user_id, $token, $timestamp) {
        $datetime = date('Y-m-d H:i:s', $timestamp);

        $query = "INSERT INTO tokens (user_id, token, timestamp) VALUES (:user_id, :token, :timestamp)";
        $stmt = BaseRepo::getDB()->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':timestamp', $datetime);
        return $stmt->execute();
    }

    public static function authenticateToken($token) {
        $query = "SELECT user_id, timestamp FROM tokens WHERE token = :token";
        $stmt = BaseRepo::getDB()->prepare($query);
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        $token_record = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$token_record) {
            return false;
        }

        self::deleteToken($token);

        $user_id = $token_record['user_id'];
        $_SESSION['user_id'] = $user_id;

        $new_token = bin2hex(random_bytes(32));
        $new_expiry = time() + (86400 * 30);

        self::addToken($user_id, $new_token, $new_expiry);

        setcookie(
            'login_cookie',
            $new_token,
            [
                'expires' => $new_expiry,
                'path' => '/',
                'httponly' => true,
                'samesite' => 'Lax'
            ]
        );

        return $user_id;
    }

    public static function deleteToken($token) {
        $query = "DELETE FROM tokens WHERE token = :token";
        $stmt = BaseRepo::getDB()->prepare($query);
        $stmt->bindParam(':token', $token);
        return $stmt->execute();
    }

    public static function purgeTokens() {
        $now = date('Y-m-d H:i:s');

        $query = "DELETE FROM tokens where timestamp < :current_timestamp";
        $stmt = BaseRepo::getDB()->prepare($query);
        $stmt->bindParam(':current_timestamp', $now);
        return $stmt->execute();
    }
}