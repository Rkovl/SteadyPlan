<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/db/database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/repos/BaseRepo.php');

class ProjectUserRepo extends BaseRepo
{

    public static function addProjectUser($projectID, $userID)
    {
        $query = "INSERT INTO projects_users (project_id, user_id) VALUES (:projectID, :userID)";
        $stmt = BaseRepo::getDB()->prepare($query);
        $stmt->bindParam(':projectID', $projectID);
        $stmt->bindParam(':userID', $userID);
        return $stmt->execute();
    }

    public static function getProjectUsers($projectID)
    {
        $query = "SELECT user_id FROM projects_users WHERE project_id = :projectID";
        $stmt = BaseRepo::getDB()->prepare($query);
        $stmt->bindParam(':projectID', $projectID);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getUserProjects($userID)
    {
        $query = "SELECT project_id FROM projects_users WHERE user_id = :userID";
        $stmt = BaseRepo::getDB()->prepare($query);
        $stmt->bindParam(':userID', $userID);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

