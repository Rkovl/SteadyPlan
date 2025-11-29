<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/db/database.php');
require_once($_SERVER['DOCUMENT_ROOT'] / '/repos/ProjectRepo.php');

class ProjectUserRepo {
    private $db;
    private $projectRepo;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
        $this->projectRepo = new ProjectRepo();
    }

    public function addProjectUser($projectID, $userID) {
        $query = "INSERT INTO projects_users (project_id, user_id) VALUES (:projectID, :userID)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':projectID', $projectID);
        $stmt->bindParam(':userID', $userID);
        return $stmt->execute();
    }

    public function getProjectUsers($projectID) {
        $query = "SELECT user_id FROM projects_users WHERE project_id = :projectID";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':projectID', $projectID);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserProjects($userID) {
        $query = "SELECT project_id FROM projects_users WHERE user_id = :userID";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':userID', $userID);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function removeUserProject($projectID, $userID) {
        if(!$this->projectRepo->getOwner($userID)) {
            $query = "DELETE FROM projects_users WHERE project_id = :projectID AND user_id = :userID";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':projectID', $projectID);
            $stmt->bindParam(':userID', $userID);
            return $stmt->execute();
        }
    }
}

