<?php
require_once(__DIR__ . '/../db/database.php');

class taskRepo {
    private $db;

    public function __construct() {
        $database = new database();
        $this->db = $database->getConnection();
    }

    public function getTask($taskID) {
        $query = "SELECT * FROM tasks WHERE id=$taskID";
        $results = pg_query_params($this->db, $query, array($taskID));
        return pg_fetch_assoc($results);
    }

    public function getTasks($projectID, $columnID) {
        $query = "SELECT * FROM tasks WHERE project_id=$projectID AND column_id=$columnID";
        $results = pg_query_params($this->db, $query, array($projectID, $columnID));
        return pg_fetch_all($results);
    }

    public function createTask($projectID, $columnID, $name, $description = null) {
        $query = "INSERT INTO tasks (project_id, column_id, name, description) VALUES ($1, $2, $3, $4) RETURNING id";
        $results = pg_query_params($this->db, $query, array($projectID, $columnID, $name, $description));

        $row = pg_fetch_row($results);
        return $row['id'];
    }

    public function deleteTask($taskID, $projectID, $columnID) {
        $query = "DELETE FROM tasks WHERE id = $1 && project_id = $2 && column_id = $3";
        $results = pg_query_params($this->db, $query, array($taskID, $projectID, $columnID));
        return $results != false;
    }

    public function changeColumn($columnID, $taskID, $projectID) {
        $query = "UPDATE tasks SET column_id = $1 WHERE id = $2 && project_id = $3";
        $results = pg_query_params($this->db, $query, array($columnID, $taskID, $projectID));
        return $results != false;
    }

    public function changeName($name, $taskID, $projectID, $columnID) {
        $query = "UPDATE tasks SET name = $1 WHERE id = $2 && project_id = $3 && column_id = $4";
        $results = pg_query_params($this->db, $query, array($name, $taskID, $projectID, $columnID));
        return $results != false;
    }

    public function changeDescription($description, $taskID, $projectID, $columnID) {
        $query = "UPDATE tasks SET description = $1 WHERE id = $2 && project_id = $3 && column_id = $4";
        $results = pg_query_params($this->db, $query, array($description, $taskID, $projectID, $columnID));
        return $results != false;
    }
}