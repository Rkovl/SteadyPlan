<?php
require_once(__DIR__ . '/../db/database.php');

class projectUserRepo {
    private $db;

    public function __construct() {
        $database = new database();
        $this->db = $database->getConnection();
    }

    public function addProjectUser($projectID, $userID) {
        $query = "INSERT INTO projects_users (project_id, user_id) VALUES ($1, $2)";
        $results = pg_query_params($this->db, $query, array($projectID, $userID));
        return $results != false;
    }

    public function getProjectUsers($projectID) {
        $query = "SELECT user_id FROM projects_users WHERE project_id = $1";
        $results = pg_query_params($this->db, $query, array($projectID));
        return pg_fetch_all($results);
    }

    public function getUserProjects($userID) {
        $query = "SELECT project_id FROM projects_users WHERE user_id = $1";
        $results = pg_query_params($this->db, $query, array($userID));
        return pg_fetch_all($results);
    }

    public function removeUserProject($projectID, $userID) {
        $query = "DELETE FROM projects_users WHERE project_id = $1 && user_id = $2";
        $results = pg_query_params($this->db, $query, array($projectID, $userID));
        return $results != false;
    }
}