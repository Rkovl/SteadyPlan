<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/db/database.php');

class ActivityRepo {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function addActivity($actionType, $projectID, $userID = null, $taskID = null, $columnID = null) {
        $query = "INSERT INTO activity (action_type, project_id, user_id, task_id, column_id) VALUES (:actionType, :projectID, :userID, :taskID, :columnID)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':actionType', $actionType);
        $stmt->bindParam(':projectID', $projectID);
        $stmt->bindParam(':userID', $userID);
        $stmt->bindParam(':taskID', $taskID);
        $stmt->bindParam(':columnID', $columnID);
        return $stmt->execute();
    }

    public function getProjectActivity($projectID, $userID) {
        $query = "SELECT * FROM activity WHERE project_id = :projectID AND user_id = :userID";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':projectID', $projectID);
        $stmt->bindParam(':userID', $userID);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}