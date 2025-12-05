<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/db/database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/repos/BaseRepo.php');

class TokensRepo extends BaseRepo
{
    public static function addToken($user_id, $token, $date) {
        $query = "INSERT INTO tokens (user_id, token, date) VALUES (:user_id, :token, :date)";
        $stmt = BaseRepo::getDB()->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':date', $date);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function isTokenValid($user_id, $token) {
        $query = "SELECT date FROM tokens WHERE user_id = :user_id AND token = :token";
        $stmt = BaseRepo::getDB()->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':token', $token);
        $stmt->execute();

        $time = $stmt->fetch(PDO::FETCH_ASSOC)['date'];
        $currentTime = time();

        if($currentTime > $time) {
            $query2 = "DELETE FROM tokens WHERE user_id = :user_id AND token = :token";
            $stmt2 = BaseRepo::getDB()->prepare($query2);
            $stmt2->bindParam(':user_id', $user_id);
            $stmt2->bindParam(':token', $token);
            $stmt2->execute();
            return false;
        }

        return true;
    }
}