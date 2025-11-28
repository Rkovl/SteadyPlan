<?php
require_once(__DIR__ . '/../db/database.php');

class activityRepo {
    private $db;

    public function __construct() {
        $database = new database();
        $this->db = $database->getConnection();
    }

    public function addActivity($actionType, $projectID, $userID = null, $taskID = null, $columnID = null) {
        $query = "INSERT INTO activity (action_type, project_id, user_id, task_id, column_id) VALUES ($1, $2, $3, $4, $5)";
        $results = pg_query_params($this->db, $query, array($actionType, $projectID, $userID, $taskID, $columnID));
        return $results != null;
    }

    public function getProjectActivity($projectID, $userID) {
        $query = "SELECT * FROM activity WHERE project_id = $1 AND user_id = $2";
        $results = pg_query_params($this->db, $query, array($projectID, $userID));
        return pg_fetch_all($results);
    }
}