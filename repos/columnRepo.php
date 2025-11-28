<?php
require_once(__DIR__ . '/../db/database.php');

class columnRepo {
    private $db;

    public function __construct(){
        $database = new database();
        $this->db = $database->getConnection();
    }

    public function addColumn($projectID, $name, $position, $description = null) {
        $query = "INSERT INTO columns (project_id, name, position, description) VALUES ($1, $2, $3, $4)";
        $results = pg_query_params($this->db, $query, array($projectID, $name, $position, $description));

        if(!$results) {
            return null;
        }

        $row = pg_fetch_assoc($results);
        return $row['id'];
    }

    public function deleteColumn($columnID) {
        $query = "DELETE FROM columns WHERE id = $columnID";
        $results = pg_query_params($this->db, $query);
        return $results != false;
    }

    public function changeName($name, $projectID, $columnID) {
        $query = "UPDATE columns SET name = $1 WHERE project_id = $2 && id == $3";
        $results = pg_query_params($this->db, $query, array($name, $projectID, $columnID));
        return $results != false;
    }

    public function changePosition($position, $projectID, $columnID) {
        $query = "UPDATE columns SET position = $1 WHERE project_id = $2 && id == $3";
        $results = pg_query_params($this->db, $query, array($position, $projectID, $columnID));
        return $results != false;
    }

    public function changeDescription($description, $projectID, $columnID) {
        $query = "UPDATE columns SET description = $1 WHERE project_id = $2 && id == $3";
        $results = pg_query_params($this->db, $query, array($description, $projectID, $columnID));
        return $results != false;
    }
}