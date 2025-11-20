<?php
require_once(__DIR__ . '/../db/database.php');

class projectRepo {
    private $db;

    function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function addProject($owner, $name) {
        $query = "INSERT INTO projects (owner, name) VALUES ($1, $2) RETURNING id";

        $results = pg_query_params($this->db, $query, array($owner, $name));

        if (!$results) {
            return null;
        }

        $row = pg_fetch_array($results);
        return $row['id'];
    }

    public function deleteProject($owner, $id) {
        $query = "DELETE FROM projects WHERE owner = $1 AND id = $2";
        $result = pg_query_params($this->db, $query, array($owner, $id));
        return $result != false;
    }

    public function changeOwner($owner, $id) {
        $query = "UPDATE projects SET owner = $1 WHERE id = $2";
        $result = pg_query_params($this->db, $query, array($owner, $id));
        return $result != false;
    }

    public function changeName($name, $id) {
        $query = "UPDATE projects SET name = $1 WHERE id = $2";
        $result = pg_query_params($this->db, $query, array($name, $id));
        return $result != false;
    }
}